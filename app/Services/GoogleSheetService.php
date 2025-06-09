<?php
namespace App\Services;
use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_Spreadsheet;
use Google_Service_Sheets_SpreadsheetProperties;
use Google_Service_Sheets_ValueRange;

class GoogleSheetService
{
    protected $client;
    protected $sheets;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName('Laravel Google Sheets');
        $this->client->setScopes([Google_Service_Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig(storage_path('app/google/service-account.json'));
        $this->client->setAccessType('offline');

        $this->sheets = new Google_Service_Sheets($this->client);
    }

    // Create a new spreadsheet
    public function createSheet($title = 'New Sheet from Laravel')
    {
        $spreadsheet = new Google_Service_Sheets_Spreadsheet([
            'properties' => new Google_Service_Sheets_SpreadsheetProperties([
                'title' => $title
            ])
        ]);

        $createdSheet = $this->sheets->spreadsheets->create($spreadsheet);

        // Set public read/write permissions using Google Drive API
        $driveService = new \Google_Service_Drive($this->client);
        $permission = new \Google_Service_Drive_Permission([
            'type' => 'anyone',
            'role' => 'writer',
        ]);
        $driveService->permissions->create(
            $createdSheet->spreadsheetId,
            $permission,
            ['fields' => 'id']
        );

        return [
            'spreadsheetId' => $createdSheet->spreadsheetId,
            'url' => $createdSheet->spreadsheetUrl,
        ];
    }
        
    // Write data to the spreadsheet
    public function writeData($spreadsheetId, $range, $values)
    {
        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);

        $params = ['valueInputOption' => 'RAW'];

        return $this->sheets->spreadsheets_values->update(
            $spreadsheetId,
            $range,
            $body,
            $params
        );
    }
}
