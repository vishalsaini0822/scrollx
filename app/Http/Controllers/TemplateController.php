<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Services\GoogleSheetService;
class TemplateController extends Controller
{
    // Display a listing of the templates
    public function index()
    {
        $templates = Template::all();
        return view('admin.templates.index', compact('templates'));
    }

    // Store a newly created template
    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_name' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('templates', 'public');
            $validated['image'] = $imagePath;
        }
        $sheet = [];
        try {
            
            $sheetService = new GoogleSheetService();
            $sheet = $sheetService->createSheet($validated['template_name'] . ' Sheet');
            $sheetService->writeData($sheet['spreadsheetId'], 'Sheet1!A1', [
                ['Template Name', 'Image Path'],
                [$validated['template_name'], $validated['image']],
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create Google Sheet: ' . $e->getMessage()], 500);
        }
        
        $template = Template::create([
            'template_name' => $validated['template_name'],
            'image' => $validated['image'],
            'sheet_url' => !empty($sheet['url']) ? $sheet['url'] : null,
            'spreadsheetId' => !empty($sheet['spreadsheetId']) ? $sheet['spreadsheetId'] : null,
        ]);
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
            'template_name' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('templates', 'public');
            $validated['image'] = $imagePath;
        }

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
