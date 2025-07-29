<?php

namespace App\Http\Controllers;

use App\Services\GoogleSheetService;

class SheetController extends Controller
{
    public function createSheet(GoogleSheetService $sheetService)
    {
        // Create new Google Sheet
        $sheet = $sheetService->createSheet('My scrollx.io Sheet');
        
        // Write some sample data
        $sheetService->writeData($sheet['spreadsheetId'], 'Sheet1!A1', [
            ['Name', 'Email'],
            ['Vishal', 'vishal@example.com'],
        ]);

        return "Google Sheet created: <a href='{$sheet['url']}' target='_blank'>{$sheet['url']}</a>";
    }
    
    public function getSheetData(GoogleSheetService $sheetService)
    {
        try {
            $spreadsheetId = '1JXRl-knr6rKE0aNdhVRUODtrdvC4O5c5jSjVUmC4TzM';
            $gid = '299738390';
            
            \Log::info('Attempting to fetch Google Sheets data', [
                'spreadsheetId' => $spreadsheetId,
                'gid' => $gid
            ]);
            
            $csvData = $sheetService->getDataAsCSV($spreadsheetId, $gid);
            
            \Log::info('Successfully fetched CSV data', ['length' => strlen($csvData)]);
            
            return response($csvData)
                ->header('Content-Type', 'text/csv')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET')
                ->header('Access-Control-Allow-Headers', 'Content-Type');
                
        } catch (\Exception $e) {
            \Log::error('Failed to fetch sheet data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => 'Failed to fetch sheet data',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function saveBlockSettings(\Illuminate\Http\Request $request)
    {
        try {
            $settings = $request->input('perBlockSettings');
            
            // Here you can save the settings to database or session
            // For now, we'll just store in session
            session(['perBlockSettings' => $settings]);
            
            return response()->json([
                'success' => true,
                'message' => 'Block settings saved successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save settings: ' . $e->getMessage()
            ], 500);
        }
    }
}

