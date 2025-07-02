<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\Template;
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
        // Set the user_id to the authenticated user's ID
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

    public function credit()
    {
        return view('dashboardinner');
    }
}
