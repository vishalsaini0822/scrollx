<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Render;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class RenderController extends Controller
{
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
            'email_notification' => 'boolean'
        ]);

        // Find the project and ensure it belongs to the authenticated user
        $project = Project::where('id', $projectId)
            ->where('user_id', Auth::id())
            ->first();

        if (!$project) {
            return response()->json(['error' => 'Project not found.'], 404);
        }

        // Create the render
        $render = Render::create([
            'project_id' => $projectId,
            'user_id' => Auth::id(),
            'resolution' => $validated['resolution'],
            'format' => $validated['format'],
            'frame_rate' => $validated['frame_rate'],
            'speed' => $validated['speed'],
            'running_time' => $validated['running_time'],
            'email_notification' => $request->has('email_notification'),
            'status' => 'processing',
            'started_at' => now()
        ]);

        // In a real application, you would queue a job to process the render
        // For now, we'll simulate it by marking it as completed after a delay
        
        return response()->json([
            'success' => true,
            'message' => 'Render started successfully!',
            'render' => $render
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

        if (!$render || !$render->file_path) {
            return response()->json(['error' => 'Render file not found.'], 404);
        }

        $filePath = storage_path('app/' . $render->file_path);
        
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'File not found on server.'], 404);
        }

        return response()->download($filePath);
    }
}
