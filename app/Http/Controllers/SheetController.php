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
}

