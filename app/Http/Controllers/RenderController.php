<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Render;
use App\Models\Project;
use App\Services\VideoRenderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RenderController extends Controller
{
    /**
     * Sanitize filename for download
     */
    private function sanitizeFilename($filename)
    {
        // Remove or replace invalid characters
        $filename = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $filename);
        // Remove multiple underscores
        $filename = preg_replace('/_{2,}/', '_', $filename);
        // Trim underscores from start and end
        return trim($filename, '_');
    }
    /**
     * Display the render page for a specific project
     */
    public function show($projectId)
    {
        // Find the project and ensure it belongs to the authenticated user
        $project = Project::where('id', $projectId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$project) {
            return redirect()->route('projects.index')->with('error', 'Project not found.');
        }

        // Get all renders for this project
        $renders = Render::where('project_id', $projectId)
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('render', compact('project', 'renders'));
    }

    /**
     * Create a new render for the project
     */
    public function store(Request $request, $projectId)
    {
        $validated = $request->validate([
            'resolution' => 'required|string',
            'format' => 'required|string',
            'frame_rate' => 'required|string',
            'speed' => 'required|integer|min:1|max:10',
            'running_time' => 'required|string',
            // 'email_notification' => 'boolean'
        ]);

        // Find the project and ensure it belongs to the authenticated user
        $project = Project::where('id', $projectId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$project) {
            return response()->json(['error' => 'Project not found.'], 404);
        }

        // Create the render record first
        $render = Render::create([
            'project_id' => $projectId,
            'user_id' => Auth::id(),
            'resolution' => $validated['resolution'],
            'format' => $validated['format'],
            'frame_rate' => $validated['frame_rate'],
            'speed' => $validated['speed'],
            'running_time' => $validated['running_time'],
            'email_notification' => $request->has('email_notification') ?? false,
            'status' => 'processing',
            'started_at' => now()
        ]);

        try {
            // Use VideoRenderService to generate actual video
            $videoRenderService = new VideoRenderService();
            $result = $videoRenderService->generateVideo($project, $validated);
            
            if ($result['success']) {
                $filePath = $result['video_path'];
                $fullPath = storage_path('app/' . $filePath);
                
                // Update the render with file information and mark as completed
                $render->update([
                    'file_path' => $filePath,
                    'file_size' => file_exists($fullPath) ? filesize($fullPath) : 0,
                    'status' => 'completed',
                    'completed_at' => now()
                ]);
                
                Log::info('Video render completed successfully', [
                    'render_id' => $render->id,
                    'project_id' => $projectId,
                    'file_path' => $filePath
                ]);
                
            } else {
                // Mark render as failed
                $render->update([
                    'status' => 'failed',
                    'completed_at' => now()
                ]);
                
                Log::error('Video render failed', [
                    'render_id' => $render->id,
                    'project_id' => $projectId,
                    'error' => $result['error'] ?? 'Unknown error'
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Video rendering failed: ' . ($result['error'] ?? 'Unknown error')
                ], 500);
            }
            
        } catch (\Exception $e) {
            // Mark render as failed
            $render->update([
                'status' => 'failed',
                'completed_at' => now()
            ]);
            
            Log::error('Exception during video render', [
                'render_id' => $render->id,
                'project_id' => $projectId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during rendering: ' . $e->getMessage()
            ], 500);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Video render completed successfully!',
            'render' => $render->fresh()
        ]);
    }

    /**
     * Delete a render
     */
    public function destroy($projectId, $renderId)
    {
        $render = Render::where('id', $renderId)
            ->where('project_id', $projectId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$render) {
            return response()->json(['error' => 'Render not found.'], 404);
        }

        // Delete the render file if it exists
        if ($render->file_path && file_exists(storage_path('app/' . $render->file_path))) {
            unlink(storage_path('app/' . $render->file_path));
        }

        $render->delete();

        return response()->json([
            'success' => true,
            'message' => 'Render deleted successfully!'
        ]);
    }

    /**
     * Download a completed render
     */
    public function download($projectId, $renderId)
    {
        $render = Render::where('id', $renderId)
            ->where('project_id', $projectId)
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->first();

        if (!$render) {
            return redirect()->back()->with('error', 'Render not found or not completed yet.');
        }

        if (!$render->file_path) {
            return redirect()->back()->with('error', 'Render file path not found.');
        }

        $filePath = storage_path('app/' . $render->file_path);
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Render file not found on server.');
        }

        // Generate a user-friendly filename
        $project = $render->project;
        $timestamp = $render->created_at->format('Y-m-d_H-i-s');
        
        // Check if HTML preview file exists (preferred download)
        $baseFilePath = pathinfo($render->file_path, PATHINFO_DIRNAME) . '/' . pathinfo($render->file_path, PATHINFO_FILENAME);
        $htmlPreviewPath = storage_path('app/' . $baseFilePath . '_video_preview.html');
        $txtSpecsPath = storage_path('app/' . $baseFilePath . '_video_specs.txt');
        
        // Determine which file to serve based on what's available and working
        if (file_exists($htmlPreviewPath)) {
            // Serve the HTML preview (always works)
            $filename = $this->sanitizeFilename($project->template_name) . '_video_preview_' . $timestamp . '.html';
            $contentType = 'text/html';
            $description = 'ScrollX.io Video Preview - ' . $project->template_name;
            $downloadPath = $htmlPreviewPath;
        } elseif (file_exists($txtSpecsPath)) {
            // Serve the text specifications file
            $filename = $this->sanitizeFilename($project->template_name) . '_video_specs_' . $timestamp . '.txt';
            $contentType = 'text/plain';
            $description = 'ScrollX.io Video Specifications - ' . $project->template_name;
            $downloadPath = $txtSpecsPath;
        } else {
            // Fallback to original MP4 file
            $fileExtension = pathinfo($render->file_path, PATHINFO_EXTENSION);
            $downloadPath = $filePath;
            
            if ($fileExtension === 'mp4') {
                $filename = $this->sanitizeFilename($project->template_name) . '_' . $timestamp . '_' . $render->resolution . '.mp4';
                $contentType = 'video/mp4';
                $description = 'ScrollX.io Video File - ' . $project->template_name;
            } elseif ($fileExtension === 'html') {
                $filename = $this->sanitizeFilename($project->template_name) . '_credits_preview_' . $timestamp . '.html';
                $contentType = 'text/html';
                $description = 'ScrollX.io Credits Preview - ' . $project->template_name;
            } else {
                $filename = $this->sanitizeFilename($project->template_name) . '_project_data_' . $timestamp . '.txt';
                $contentType = 'text/plain';
                $description = 'ScrollX.io Project Data - ' . $project->template_name;
            }
        }
        
        $headers = [
            'Content-Type' => $contentType,
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Description' => $description,
        ];
        
        return response()->download($downloadPath, $filename, $headers);
    }
}
