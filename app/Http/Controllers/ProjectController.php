<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\Template;
use App\Services\GoogleSheetService;
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access the dashboard.');
        }  

        $projects = Project::where('user_id', Auth::id())->orderBy('id','desc')->get();
        $template = Template::get();
        return view('dashboard', ['projects' => $projects,'template'=>$template]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_name' => 'required|string|max:255',
            'end_credits_type' => 'required|string|max:255',
            'resolution' => 'nullable|string|max:255',
        ]);
        $project = new Project;
        $project->template_id = !empty($request->input('template_id')) ? $request->input('template_id') : 0;
        $project->template_name = $validated['template_name'];
        $project->end_credits_type = $validated['end_credits_type'];
        $project->resolution = $validated['resolution'] ?? null;
        $project->status = 'no_status';

        dd(storage_path('app/google/service-account.json'));
        $sheetService = new GoogleSheetService();
        $result = $sheetService->createSheet('Demo Sheet');
        dd($result);
        if ($result) {
            return response()->json([
                'message' => 'Sheet created successfully!',
                'url' => $result['url'],
            ]);
        } else {
            return response()->json(['error' => 'Failed to create sheet'], 500);
        }
        $project->user_id = auth()->user()->id;
        $project->save();

        return response()->json(['success' => true, 'project' => $project]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find the project by ID and ensure it belongs to the authenticated user
        $project = Project::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$project) {
            return response()->json(['error' => 'Project not found.'], 404);
        }

        // Return project data as JSON for AJAX
        return response()->json([
            'template_name' => $project->template_name,
            'end_credits_type' => $project->end_credits_type,
            'resolution' => $project->resolution,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
        $validated = $request->validate([
            'template_name' => 'required|string|max:255',
            'end_credits_type' => 'required|string|max:255',
            'resolution' => 'nullable|string|max:255',
        ]);
        // Find the project by ID and ensure it belongs to the authenticated user
        $project = Project::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$project) {
            return response()->json(['error' => 'Project not found.'], 404);
        }

        // Update the project fields
        $project->template_name = $validated['template_name'];
        $project->end_credits_type = $validated['end_credits_type'];
        $project->resolution = $validated['resolution'] ?? null;
        $project->save();

        // Return a JSON response
        return response()->json(['success' => true, 'project' => $project]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //  Find the project by ID and ensure it belongs to the authenticated user
        $project = Project::where('id', $id)    
            ->where('user_id', Auth::id())
            ->first();
        if (!$project) {
            return response()->json(['error' => 'Project not found.'], 404);
        }
        // Delete the project
        $project->delete();     
        // Return a JSON response
        return response()->json(['success' => true, 'message' => 'Project deleted successfully.']);
    }

    public function changeStatus(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'status' => 'required|string',
        ]);

        // Find the project by ID and ensure it belongs to the authenticated user
        $project = Project::where('id', $validated['project_id'])
            ->where('user_id', Auth::id())
            ->first();

        if (!$project) {
            return response()->json(['error' => 'Project not found.'], 404);
        }

        // Update the project status
        $project->status = $validated['status'];
        $project->save();

        // Return a JSON response
        return response()->json(['success' => true, 'project' => $project]);
    }
    public function copyProject(Request $request ,$id)
    {
        $project = Project::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$project) {
            return redirect()->back()->with('error', 'Project not found.');
        }
        $newProject = $project->replicate();
        $newProject->template_name = !empty($request->template_name)?$request->template_name:$newProject->template_name;
        $newProject->status = 'no_status'; // Reset status for the new project
        $newProject->save();

        return redirect()->route('projects.index')->with('success', 'Project copied successfully.');
    }

    public function credit($id)
    {   
        // Find the project by ID and ensure it belongs to the authenticated user
        $project = Project::where('id', $id)    
            ->where('user_id', Auth::id())
            ->first();  
        if (!$project) {
            return redirect('dashboard')->with('toastr_error', 'Project not found.');
        }
        return view('dashboardinner',compact('project'));
    }

    public function render($id)
    {   
        // Find the project by ID and ensure it belongs to the authenticated user
        $project = Project::where('id', $id)    
            ->where('user_id', Auth::id())
            ->first();  
        if (!$project) {
            return redirect('dashboard')->with('toastr_error', 'Project not found.');
        }
        return view('render',compact('project'));
    }

    public function saveBlockSettings(Request $request)
    {
        dd($request->all());
        return response()->json(['success' => true, 'message' => 'Block settings saved successfully.']);
    }

    /**
     * Get the Google Sheet URL for a specific project
     */
    public function getProjectGoogleSheet($projectId)
    {
        try {
            // Find the project by ID and ensure it belongs to the authenticated user
            $project = Project::where('id', $projectId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found.'
                ], 404);
            }

            if ($project->google_sheet_url) {
                return response()->json([
                    'success' => true,
                    'sheetUrl' => $project->google_sheet_url,
                    'sheetId' => $project->google_sheet_id
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No Google Sheet associated with this project.'
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('Error getting project Google Sheet:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve Google Sheet information.'
            ], 500);
        }
    }

    /**
     * Create a new Google Sheet for a project
     */
    public function createProjectGoogleSheet(Request $request, GoogleSheetService $sheetService)
    {
        try {
            $validated = $request->validate([
                'projectId' => 'required|exists:projects,id',
                'projectName' => 'required|string|max:255'
            ]);

            // Find the project by ID and ensure it belongs to the authenticated user
            $project = Project::where('id', $validated['projectId'])
                ->where('user_id', Auth::id())
                ->first();

            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found.'
                ], 404);
            }

            // Create new Google Sheet with a descriptive title
            $sheetTitle = "Credits - {$validated['projectName']} - " . date('Y-m-d');
            $sheet = $sheetService->createSheet($sheetTitle);

            // Set up the sheet with initial credit structure
            $initialData = [
                ['HOW TO USE THE CREDIT SHEET?', '', '', '', '', ''],
                ['', '', '', '', '', ''],
                ['', '', 'Use ROLE + NAME blocks for common credits like cast and crew', '', '', ''],
                ['', '', 'Add your credits below this line:', '', '', ''],
                ['', '', '', '', '', ''],
                ['PRODUCTION', '', '', '', '', ''],
                ['', 'Director', 'Your Name Here', '', '', ''],
                ['', 'Producer', 'Your Name Here', '', '', ''],
                ['', 'Writer', 'Your Name Here', '', '', ''],
                ['', '', '', '', '', ''],
                ['CAST', '', '', '', '', ''],
                ['', 'MAIN CHARACTER', 'Actor Name Here', '', '', ''],
                ['', 'SUPPORTING CHARACTER', 'Actor Name Here', '', '', ''],
                ['', '', '', '', '', ''],
                ['CREW', '', '', '', '', ''],
                ['', 'Director of Photography', 'Your Name Here', '', '', ''],
                ['', 'Editor', 'Your Name Here', '', '', ''],
                ['', 'Sound Designer', 'Your Name Here', '', '', '']
            ];

            // Write the initial data to the sheet
            $sheetService->writeData($sheet['spreadsheetId'], 'Sheet1!A1', $initialData);

            // Update the project with the Google Sheet information
            $project->google_sheet_url = $sheet['url'];
            $project->google_sheet_id = $sheet['spreadsheetId'];
            $project->save();

            return response()->json([
                'success' => true,
                'sheetUrl' => $sheet['url'],
                'sheetId' => $sheet['spreadsheetId'],
                'message' => 'Google Sheet created successfully!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error creating project Google Sheet:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to create Google Sheet. Please try again.'
            ], 500);
        }
    }

    /**
     * Get sheet data for a specific project
     */
    public function getProjectSheetData($projectId, GoogleSheetService $sheetService)
    {
        try {
            // Find the project by ID and ensure it belongs to the authenticated user
            $project = Project::where('id', $projectId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found.'
                ], 404);
            }

            if (!$project->google_sheet_id) {
                // If no Google Sheet is associated, return the default sample data
                return $this->getDefaultSheetData();
            }

            try {
                // Try to get data from the project's Google Sheet
                $csvData = $sheetService->getDataAsCSV($project->google_sheet_id);
                
                return response($csvData)
                    ->header('Content-Type', 'text/csv')
                    ->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods', 'GET')
                    ->header('Access-Control-Allow-Headers', 'Content-Type');
                    
            } catch (\Exception $e) {
                \Log::warning('Failed to fetch project Google Sheet data, falling back to default', [
                    'projectId' => $projectId,
                    'sheetId' => $project->google_sheet_id,
                    'error' => $e->getMessage()
                ]);
                
                // Fallback to default data if Google Sheet is not accessible
                return $this->getDefaultSheetData();
            }

        } catch (\Exception $e) {
            \Log::error('Error getting project sheet data:', [
                'projectId' => $projectId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve sheet data.'
            ], 500);
        }
    }

    /**
     * Get default sheet data as CSV when no Google Sheet is available
     */
    private function getDefaultSheetData()
    {
        $defaultData = "block_name,role,name,logo,blurb,song_title,song_details\n";
        $defaultData .= "HOW TO USE THE CREDIT SHEET?,,,,,,\n";
        $defaultData .= ",,,,,,\n";
        $defaultData .= ",,,,,,\n";
        $defaultData .= "Use ROLE + NAME blocks for common credits like cast and crew,,,,,,\n";
        $defaultData .= ",,,,,,\n";
        $defaultData .= "DCA,,,,,,\n";
        $defaultData .= ",Line Producer,Winnie Bong,,,,\n";
        $defaultData .= ",Unit Production Manager,Healin Keon,,,,\n";
        $defaultData .= ",First Assistant Director,Samantha Gao,,,,\n";
        $defaultData .= ",Second Assistant Director,Cutter White,,,,\n";
        $defaultData .= ",,,,,,\n";
        $defaultData .= "CAST,,,,,,\n";
        $defaultData .= ",HAYOUNG,Ji-young Yoo,,,,\n";
        $defaultData .= ",APPA,Jung Joon Ho,,,,\n";
        $defaultData .= ",MRS. CHOI,Jessica Whang,,,,\n";
        $defaultData .= ",UMMA,Abin Andrews,,,,\n";
        $defaultData .= ",ARA,Erin Choi,,,,\n";

        return response($defaultData)
            ->header('Content-Type', 'text/csv')
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET')
            ->header('Access-Control-Allow-Headers', 'Content-Type');
    }

    /**
     * Start a new render for a project
     */
    public function startRender(Request $request)
    {
        try {
            $validated = $request->validate([
                'projectId' => 'required|exists:projects,id',
                'resolution' => 'required|string',
                'format' => 'required|string',
                'frameRate' => 'required|string',
                'speed' => 'required|integer|min:1|max:20',
                'emailNotification' => 'boolean'
            ]);

            // Find the project by ID and ensure it belongs to the authenticated user
            $project = Project::where('id', $validated['projectId'])
                ->where('user_id', Auth::id())
                ->first();

            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found.'
                ], 404);
            }

            // Calculate running time based on speed
            $baseTime = 113; // seconds (1:53)
            $timeMultiplier = 5 / $validated['speed'];
            $totalSeconds = (int) round($baseTime * $timeMultiplier);
            $minutes = (int) floor($totalSeconds / 60);
            $seconds = $totalSeconds % 60;
            $runningTime = sprintf('%02d:%02d', $minutes, $seconds);

            // For now, we'll simulate the render process
            // In a real application, this would queue a background job
            $renderData = [
                'id' => time(), // Temporary ID
                'project_id' => $validated['projectId'],
                'user_id' => Auth::id(),
                'resolution' => $validated['resolution'],
                'format' => $validated['format'],
                'frame_rate' => $validated['frameRate'],
                'speed' => $validated['speed'],
                'running_time' => $runningTime,
                'status' => 'processing',
                'email_notification' => $validated['emailNotification'] ?? true,
                'started_at' => now(),
                'version' => $this->getNextRenderVersion($validated['projectId'])
            ];

            // Store in session for now (in production, this would be stored in database)
            $renders = session('renders', []);
            $renders[] = $renderData;
            session(['renders' => $renders]);

            return response()->json([
                'success' => true,
                'message' => 'Render started successfully!',
                'render' => $renderData
            ]);

        } catch (\Exception $e) {
            \Log::error('Error starting render:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to start render. Please try again.'
            ], 500);
        }
    }

    /**
     * Get render history for a project
     */
    public function getRenderHistory($projectId)
    {
        try {
            // Find the project by ID and ensure it belongs to the authenticated user
            $project = Project::where('id', $projectId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$project) {
                return response()->json([
                    'success' => false,
                    'message' => 'Project not found.'
                ], 404);
            }

            // Get renders from session (in production, this would come from database)
            $allRenders = session('renders', []);
            $projectRenders = array_filter($allRenders, function($render) use ($projectId) {
                return $render['project_id'] == $projectId;
            });

            // Sort by created date (newest first)
            usort($projectRenders, function($a, $b) {
                return strtotime($b['started_at']) - strtotime($a['started_at']);
            });

            return response()->json([
                'success' => true,
                'renders' => array_values($projectRenders)
            ]);

        } catch (\Exception $e) {
            \Log::error('Error getting render history:', [
                'projectId' => $projectId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve render history.'
            ], 500);
        }
    }

    /**
     * Get the next version number for renders in this project
     */
    private function getNextRenderVersion($projectId)
    {
        $allRenders = session('renders', []);
        $projectRenders = array_filter($allRenders, function($render) use ($projectId) {
            return $render['project_id'] == $projectId;
        });

        return count($projectRenders) + 1;
    }
}
