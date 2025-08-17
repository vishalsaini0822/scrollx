<?php
require_once 'vendor/autoload.php';

// Test the NEW enhanced MP4 generation method
use App\Services\SimpleVideoGenerator;

echo "Testing NEW Enhanced MP4 Generation (Windows Media Player Compatible)...\n\n";

// Create a test project object
$project = (object) [
    'id' => 'test_456',
    'template_name' => 'Windows Compatible Test',
    'user_id' => 1,
    'google_sheet_url' => null
];

// Test render settings
$width = 1280;
$height = 720;
$frameRate = 30;
$duration = 15;

$renderSettings = [
    'resolution' => '1280x720',
    'frame_rate' => '30',
    'running_time' => '00:15',
    'speed' => 'normal'
];

// Test credits data
$creditsData = [
    ['type' => 'title', 'text' => 'Windows Media Player Test'],
    ['type' => 'credit', 'role' => 'Director', 'name' => 'ScrollX.io'],
    ['type' => 'credit', 'role' => 'Producer', 'name' => 'Video Generator'],
    ['type' => 'name', 'text' => 'Test User']
];

$outputPath = 'test_windows_compatible.mp4';

try {
    echo "Generating MP4 with enhanced structure...\n";
    
    $result = SimpleVideoGenerator::generateMP4(
        $outputPath,
        $width,
        $height,
        $frameRate,
        $duration,
        $project,
        $renderSettings,
        $creditsData
    );
    
    if ($result && file_exists($outputPath)) {
        echo "✅ Enhanced MP4 file created successfully: $outputPath\n";
        echo "File size: " . number_format(filesize($outputPath) / 1024, 2) . " KB\n";
        
        // Check file structure
        $handle = fopen($outputPath, 'rb');
        $header = fread($handle, 128);
        fclose($handle);
        
        echo "\nFile Structure Analysis:\n";
        if (strpos($header, 'ftyp') !== false) {
            echo "✅ File Type box (ftyp) found\n";
        }
        if (strpos($header, 'mp42') !== false) {
            echo "✅ MP4 brand compatibility (mp42) found\n";
        }
        if (strpos($header, 'moov') !== false) {
            echo "✅ Movie metadata box (moov) found\n";
        }
        if (strpos($header, 'mdat') !== false) {
            echo "✅ Media data box (mdat) found\n";
        }
        
        echo "\n🎯 This file should now be playable in Windows Media Player!\n";
        echo "📁 Test file location: " . realpath($outputPath) . "\n";
        echo "\n💡 Try opening this file in Windows Media Player to verify compatibility.\n";
        
    } else {
        echo "❌ Failed to create MP4 file\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
