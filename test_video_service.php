<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "Testing VideoRenderService...\n";
    
    // Create a test project
    $project = new \App\Models\Project();
    $project->id = 999;
    $project->user_id = 1;
    $project->template_name = 'Test Movie Credits';
    $project->google_sheet_url = null;
    
    // Test render settings
    $renderSettings = [
        'resolution' => '1280x720',
        'format' => 'H264',
        'frame_rate' => '23.976',
        'speed' => '5',
        'running_time' => '02:30'
    ];
    
    // Test the service
    $service = new \App\Services\VideoRenderService();
    $result = $service->generateVideo($project, $renderSettings);
    
    if ($result['success']) {
        echo "SUCCESS: Video generated at " . $result['video_path'] . "\n";
        
        // Check if file exists
        $fullPath = storage_path('app/' . $result['video_path']);
        if (file_exists($fullPath)) {
            echo "File exists: " . $fullPath . "\n";
            echo "File size: " . number_format(filesize($fullPath)) . " bytes\n";
            
            // Show first few lines of content
            $content = file_get_contents($fullPath);
            $lines = explode("\n", $content);
            echo "First 10 lines:\n";
            for ($i = 0; $i < min(10, count($lines)); $i++) {
                echo "  " . $lines[$i] . "\n";
            }
        } else {
            echo "ERROR: File not found at " . $fullPath . "\n";
        }
    } else {
        echo "ERROR: " . $result['error'] . "\n";
    }
    
} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
