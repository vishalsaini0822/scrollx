<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;

class TemplateController extends Controller
{
    // Display a listing of the templates
    public function index()
    {
        $templates = Template::all();
        return response()->json($templates);
    }

    // Store a newly created template
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|string|max:255',
        ]);

        $template = Template::create($validated);

        return response()->json($template, 201);
    }

    // Display the specified template
    public function show($id)
    {
        $template = Template::find($id);

        if (!$template) {
            return response()->json(['message' => 'Template not found'], 404);
        }

        return response()->json($template);
    }

    // Update the specified template
    public function update(Request $request, $id)
    {
        $template = Template::find($id);

        if (!$template) {
            return response()->json(['message' => 'Template not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|required|string|max:255',
        ]);

        $template->update($validated);

        return response()->json($template);
    }

    // Remove the specified template
    public function destroy($id)
    {
        $template = Template::find($id);

        if (!$template) {
            return response()->json(['message' => 'Template not found'], 404);
        }

        $template->delete();

        return response()->json(['message' => 'Template deleted successfully']);
    }
}
