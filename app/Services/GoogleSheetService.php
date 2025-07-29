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

        // IMPORTANT: Share your Google Drive folder or the created sheet with the service account email as an editor.
        // You can find the service account email in your service-account.json file under the "client_email" field.
        // Example: share the folder or file in Google Drive UI with: your-service-account@your-project.iam.gserviceaccount.com

        // Optionally, set permissions programmatically if the Drive API is enabled and the service account has sharing rights.
        try {
            $driveService = new \Google_Service_Drive($this->client);

            // Share with your own Google account email (replace with your email)
            $userPermission = new \Google_Service_Drive_Permission([
                'type' => 'user',
                'role' => 'writer',
                'emailAddress' => 'bajranginfotech89@gmail.com' // <-- Replace with your Google account email
            ]);
            $driveService->permissions->create(
                $createdSheet->spreadsheetId,
                $userPermission,
                ['fields' => 'id', 'sendNotificationEmail' => false]
            );

            // Optionally, keep the 'anyone' permission if you want public write access (not recommended)
            /*
            $anyonePermission = new \Google_Service_Drive_Permission([
                'type' => 'anyone',
                'role' => 'writer',
            ]);
            $driveService->permissions->create(
                $createdSheet->spreadsheetId,
                $anyonePermission,
                ['fields' => 'id']
            );
            */
        } catch (\Google_Service_Exception $e) {
            // Log or handle the error, but do not stop execution
            // error_log('Failed to set permissions: ' . $e->getMessage());
        }

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
    
    // Read data from the spreadsheet and return as CSV format
    public function getDataAsCSV($spreadsheetId, $gid = '0')
    {
        try {
            // Use the CSV export URL for faster and simpler data retrieval
            $csvUrl = "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/export?format=csv&gid={$gid}";
            
            // Create a context for the file_get_contents to handle any potential headers
            $context = stream_context_create([
                'http' => [
                    'timeout' => 30, // 30 seconds timeout
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'header' => "Accept: text/csv\r\n"
                ]
            ]);
            
            $csvData = file_get_contents($csvUrl, false, $context);
            
            if ($csvData === false) {
                // If direct file_get_contents fails, try using cURL
                return $this->getDataWithCurl($csvUrl);
            }
            
            return $csvData;
            
        } catch (\Exception $e) {
            throw new \Exception('Error fetching sheet data: ' . $e->getMessage());
        }
    }
    
    // Fallback method using cURL
    private function getDataWithCurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: text/csv'
        ]);
        
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new \Exception('cURL error: ' . $error);
        }
        
        if ($httpCode !== 200) {
            throw new \Exception('HTTP error: ' . $httpCode);
        }
        
        if ($data === false) {
            throw new \Exception('Failed to fetch data with cURL');
        }
        
        return $data;
    }
    
    // Read data from the spreadsheet using the Sheets API
    public function readData($spreadsheetId, $range = 'Sheet1')
    {
        try {
            $response = $this->sheets->spreadsheets_values->get($spreadsheetId, $range);
            return $response->getValues();
        } catch (\Google_Service_Exception $e) {
            throw new \Exception('Error reading sheet data: ' . $e->getMessage());
        }
    }
}
