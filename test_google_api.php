<?php

require_once 'vendor/autoload.php';

echo "Testing Google Sheets API Connection...\n";

try {
    // Test basic Google Client setup
    $client = new Google_Client();
    $client->setApplicationName('scrollx Google Sheets Test');
    $client->setScopes([
        Google_Service_Sheets::SPREADSHEETS,
        Google_Service_Drive::DRIVE,
        Google_Service_Drive::DRIVE_FILE,
        Google_Service_Drive::DRIVE_METADATA,
    ]);
    
    $serviceAccountPath = 'storage/app/google/service-account.json';
    if (!file_exists($serviceAccountPath)) {
        throw new Exception('Service account file not found at: ' . $serviceAccountPath);
    }
    
    echo "✓ Service account file exists\n";
    
    $client->setAuthConfig($serviceAccountPath);
    echo "✓ Google Client configured\n";
    
    // Test Sheets API
    $sheets = new Google_Service_Sheets($client);
    echo "✓ Google Sheets service created\n";
    
    // Test Drive API  
    $drive = new Google_Service_Drive($client);
    echo "✓ Google Drive service created\n";
    
    // Try to list a few files to test permissions
    echo "Testing API permissions...\n";
    $files = $drive->files->listFiles([
        'pageSize' => 1,
        'q' => "mimeType='application/vnd.google-apps.spreadsheet'"
    ]);
    echo "✓ Successfully queried Google Drive API\n";
    
    // Try to create a test spreadsheet
    echo "Testing spreadsheet creation...\n";
    $spreadsheet = new Google_Service_Sheets_Spreadsheet([
        'properties' => new Google_Service_Sheets_SpreadsheetProperties([
            'title' => 'Test Sheet - ' . date('Y-m-d H:i:s')
        ])
    ]);
    
    $createdSheet = $sheets->spreadsheets->create($spreadsheet);
    echo "✓ Successfully created test spreadsheet: " . $createdSheet->spreadsheetId . "\n";
    echo "✓ Spreadsheet URL: " . $createdSheet->spreadsheetUrl . "\n";
    
    echo "\n🎉 All tests passed! Google Sheets API is working correctly.\n";
    
} catch (Google_Service_Exception $e) {
    echo "❌ Google Service Exception:\n";
    echo "HTTP Code: " . $e->getCode() . "\n";
    echo "Error Message: " . $e->getMessage() . "\n";
    
    if ($e->getCode() == 403) {
        echo "\n💡 This is a permissions error. Please:\n";
        echo "1. Go to Google Cloud Console: https://console.cloud.google.com/\n";
        echo "2. Select your project: scrollx-july-19\n";
        echo "3. Go to 'APIs & Services' > 'Library'\n";
        echo "4. Search for and enable 'Google Sheets API'\n";
        echo "5. Search for and enable 'Google Drive API'\n";
        echo "6. Make sure your service account has the necessary permissions\n";
    }
    
} catch (Exception $e) {
    echo "❌ General Exception: " . $e->getMessage() . "\n";
}
