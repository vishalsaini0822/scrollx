<?php

require_once 'vendor/autoload.php';

echo "=== Google API Comprehensive Test ===\n\n";

try {
    $serviceAccountPath = __DIR__ . '/storage/app/google/service-account.json';
    
    if (!file_exists($serviceAccountPath)) {
        throw new Exception('Service account file not found');
    }
    
    echo "✓ Service account file exists\n";
    
    $serviceAccountData = json_decode(file_get_contents($serviceAccountPath), true);
    echo "✓ Service account email: " . $serviceAccountData['client_email'] . "\n";
    echo "✓ Project ID: " . $serviceAccountData['project_id'] . "\n\n";

    // Initialize Google Client
    $client = new Google_Client();
    $client->setApplicationName('scrollx Test');
    $client->setScopes([
        Google_Service_Sheets::SPREADSHEETS,
        Google_Service_Drive::DRIVE,
        Google_Service_Drive::DRIVE_FILE,
    ]);
    $client->setAuthConfig($serviceAccountPath);
    
    echo "✓ Google Client initialized\n";

    // Test creating a spreadsheet
    echo "\nTesting spreadsheet creation...\n";
    $sheetsService = new Google_Service_Sheets($client);
    
    $spreadsheet = new Google_Service_Sheets_Spreadsheet([
        'properties' => new Google_Service_Sheets_SpreadsheetProperties([
            'title' => 'Test Sheet - ' . date('Y-m-d H:i:s')
        ])
    ]);

    echo "Attempting to create spreadsheet...\n";
    $createdSheet = $sheetsService->spreadsheets->create($spreadsheet);
    
    echo "✓ Spreadsheet created successfully!\n";
    echo "✓ Spreadsheet ID: " . $createdSheet->spreadsheetId . "\n";
    echo "✓ Spreadsheet URL: " . $createdSheet->spreadsheetUrl . "\n\n";

    // Test writing data
    echo "Testing data writing...\n";
    $values = [
        ['Name', 'Value'],
        ['Test', 'Data']
    ];
    
    $body = new Google_Service_Sheets_ValueRange([
        'values' => $values
    ]);
    
    $params = [
        'valueInputOption' => 'RAW'
    ];
    
    $result = $sheetsService->spreadsheets_values->update(
        $createdSheet->spreadsheetId,
        'Sheet1!A1',
        $body,
        $params
    );
    
    echo "✓ Data written successfully!\n";
    echo "✓ Updated " . $result->getUpdatedCells() . " cells\n\n";

    // Test Drive permissions
    echo "Testing Drive permissions...\n";
    $driveService = new Google_Service_Drive($client);
    
    $userPermission = new Google_Service_Drive_Permission([
        'type' => 'user',
        'role' => 'writer',
        'emailAddress' => 'bajranginfotech89@gmail.com'
    ]);
    
    $permission = $driveService->permissions->create(
        $createdSheet->spreadsheetId,
        $userPermission,
        ['fields' => 'id', 'sendNotificationEmail' => false]
    );
    
    echo "✓ Permission set successfully!\n";
    echo "✓ Permission ID: " . $permission->getId() . "\n\n";

    // Clean up
    echo "Cleaning up test file...\n";
    $driveService->files->delete($createdSheet->spreadsheetId);
    echo "✓ Test file deleted\n\n";

    echo "🎉 ALL TESTS PASSED! Your Google API setup is working correctly.\n";
    echo "The issue might be elsewhere in your application.\n";

} catch (Google_Service_Exception $e) {
    echo "\n❌ Google Service Exception:\n";
    echo "HTTP Code: " . $e->getCode() . "\n";
    echo "Error Details: " . $e->getMessage() . "\n\n";
    
    $errorData = json_decode($e->getMessage(), true);
    if ($errorData && isset($errorData['error'])) {
        echo "Error Code: " . $errorData['error']['code'] . "\n";
        echo "Error Message: " . $errorData['error']['message'] . "\n";
        echo "Status: " . ($errorData['error']['status'] ?? 'Unknown') . "\n\n";
        
        if ($errorData['error']['code'] == 403) {
            echo "🔧 403 Forbidden Solutions:\n";
            echo "1. Check if billing is enabled for your project\n";
            echo "2. Verify service account has the correct IAM roles\n";
            echo "3. Make sure you're using the correct service account file\n";
            echo "4. Check API quotas and limits\n";
        }
    }
    
} catch (Exception $e) {
    echo "\n❌ General Exception:\n";
    echo "Message: " . $e->getMessage() . "\n";
}
