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
        $this->client->setApplicationName('scrollx Google Sheets');
        $this->client->setScopes([
                    \Google_Service_Sheets::SPREADSHEETS,
                    \Google_Service_Drive::DRIVE,
                    \Google_Service_Drive::DRIVE_FILE,
                    \Google_Service_Drive::DRIVE_METADATA,
                ]);
        $this->client->setAuthConfig(storage_path('app/google/service-account.json'));
        $this->client->setAccessType('offline');

        // IMPORTANT: Share your target Google Drive folder or Sheet with the service account email as an editor.
        // You can find the service account email in your service-account.json file under the "client_email" field.
        // Example: share the folder or file in Google Drive UI with: your-service-account@your-project.iam.gserviceaccount.com

        $this->sheets = new Google_Service_Sheets($this->client);
    }

    // Create a new spreadsheet
    public function createSheet($title = 'New Sheet from scrollx')
    {
        $spreadsheet = new Google_Service_Sheets_Spreadsheet([
            'properties' => new Google_Service_Sheets_SpreadsheetProperties([
                'title' => $title
            ])
        ]);

        $createdSheet = $this->sheets->spreadsheets->create($spreadsheet);
        // Set public read/write permissions using Google Drive API
        // Make sure the Drive API is enabled for your project and the service account has permission to share files.
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
