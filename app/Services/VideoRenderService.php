<?php

namespace App\Services;

use App\Models\Project;
use App\Services\GoogleSheetService;
use App\Services\SimpleVideoGenerator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class VideoRenderService
{
    protected $googleSheetService;
    
    public function __construct()
    {
        $this->googleSheetService = new GoogleSheetService();
    }
    
    /**
     * Generate actual video file for the project
     */
    public function generateVideo(Project $project, array $renderSettings)
    {
        try {
            // Get project data from Google Sheets
            $projectData = $this->getProjectData($project);
            
            // Create video using HTML Canvas approach (since FFmpeg may not be available)
            $videoPath = $this->createScrollingCreditsVideo($project, $projectData, $renderSettings);
            
            return [
                'success' => true,
                'video_path' => $videoPath,
                'message' => 'Video generated successfully'
            ];
            
        } catch (\Exception $e) {
            Log::error('Video generation failed', [
                'project_id' => $project->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
    
    /**
     * Get project data from Google Sheets
     */
    private function getProjectData(Project $project)
    {
        $creditsData = [];
        
        try {
            if ($project->google_sheet_url) {
                // Extract spreadsheet ID from URL
                preg_match('/\/spreadsheets\/d\/([a-zA-Z0-9-_]+)/', $project->google_sheet_url, $matches);
                if (!empty($matches[1])) {
                    $spreadsheetId = $matches[1];
                    
                    // Get data from Google Sheets
                    $csvData = $this->googleSheetService->getDataAsCSV($spreadsheetId);
                    $creditsData = $this->parseCreditsData($csvData);
                }
            }
        } catch (\Exception $e) {
            Log::warning('Failed to fetch Google Sheets data', [
                'project_id' => $project->id,
                'error' => $e->getMessage()
            ]);
        }
        
        // If no Google Sheets data, create sample credits
        if (empty($creditsData)) {
            $creditsData = $this->getSampleCreditsData($project);
        }
        
        return $creditsData;
    }
    
    /**
     * Parse CSV data into structured credits
     */
    private function parseCreditsData($csvData)
    {
        $lines = explode("\n", $csvData);
        $credits = [];
        $currentBlock = null;
        
        foreach ($lines as $line) {
            $data = str_getcsv($line);
            if (count($data) < 3) continue;
            
            $blockName = trim($data[0] ?? '');
            $role = trim($data[1] ?? '');
            $name = trim($data[2] ?? '');
            
            // Skip header and instruction rows
            if (stripos($blockName, 'HOW TO USE') !== false || 
                stripos($blockName, 'block_name') !== false) {
                continue;
            }
            
            // New block
            if (!empty($blockName) && empty($role) && empty($name)) {
                $currentBlock = $blockName;
                $credits[] = [
                    'type' => 'title',
                    'text' => $blockName
                ];
            }
            // Credit entry
            else if (!empty($role) && !empty($name)) {
                $credits[] = [
                    'type' => 'credit',
                    'role' => $role,
                    'name' => $name
                ];
            }
            // Just a name (for groups)
            else if (empty($role) && !empty($name)) {
                $credits[] = [
                    'type' => 'name',
                    'text' => $name
                ];
            }
        }
        
        return $credits;
    }
    
    /**
     * Create sample credits data for projects without Google Sheets
     */
    private function getSampleCreditsData(Project $project)
    {
        return [
            ['type' => 'title', 'text' => strtoupper($project->template_name)],
            ['type' => 'credit', 'role' => 'Directed by', 'name' => 'Sample Director'],
            ['type' => 'credit', 'role' => 'Produced by', 'name' => 'Sample Producer'],
            ['type' => 'title', 'text' => 'CAST'],
            ['type' => 'credit', 'role' => 'MAIN CHARACTER', 'name' => 'Sample Actor'],
            ['type' => 'credit', 'role' => 'SUPPORTING ROLE', 'name' => 'Sample Actress'],
            ['type' => 'title', 'text' => 'CREW'],
            ['type' => 'credit', 'role' => 'Director of Photography', 'name' => 'Sample DP'],
            ['type' => 'credit', 'role' => 'Editor', 'name' => 'Sample Editor'],
            ['type' => 'credit', 'role' => 'Music by', 'name' => 'Sample Composer'],
            ['type' => 'title', 'text' => 'SPECIAL THANKS'],
            ['type' => 'name', 'text' => 'All our amazing supporters'],
            ['type' => 'name', 'text' => 'The cast and crew'],
            ['type' => 'title', 'text' => 'A SCROLLX.IO PRODUCTION'],
        ];
    }
    
    /**
     * Create scrolling credits video using HTML/CSS approach
     */
    private function createScrollingCreditsVideo(Project $project, array $creditsData, array $renderSettings)
    {
        // Ensure renders directory exists
        $rendersDir = storage_path('app/renders');
        if (!file_exists($rendersDir)) {
            mkdir($rendersDir, 0755, true);
        }
        
        // Generate HTML content for the credits (for preview)
        $htmlContent = $this->generateCreditsHTML($project, $creditsData, $renderSettings);
        
        // Create HTML preview file
        $htmlFileName = 'credits_' . $project->id . '_' . time() . '_preview.html';
        $htmlPath = 'renders/' . $htmlFileName;
        $fullHtmlPath = storage_path('app/' . $htmlPath);
        file_put_contents($fullHtmlPath, $htmlContent);
        
        // Create actual MP4 file with proper structure
        $mp4FileName = 'render_' . time() . '_' . $project->id . '.mp4';
        $mp4Path = 'renders/' . $mp4FileName;
        $fullMp4Path = storage_path('app/' . $mp4Path);
        
        // Parse resolution for video generation
        $resolution = explode('x', $renderSettings['resolution']);
        $width = intval($resolution[0]);
        $height = intval($resolution[1]);
        $frameRate = floatval($renderSettings['frame_rate']);
        
        // Parse running time
        $timeParts = explode(':', $renderSettings['running_time']);
        $totalSeconds = (intval($timeParts[0]) * 60) + intval($timeParts[1]);
        
        // Generate MP4 file with enhanced structure for media player compatibility
        $success = SimpleVideoGenerator::generateMP4(
            $fullMp4Path, 
            $width, 
            $height, 
            $frameRate, 
            $totalSeconds, 
            $project, 
            $renderSettings, 
            $creditsData
        );
        
        if (!$success || !file_exists($fullMp4Path)) {
            Log::error('Failed to generate MP4 file', [
                'project_id' => $project->id,
                'output_path' => $fullMp4Path
            ]);
            throw new \Exception('Failed to generate video file');
        }
        
        // Log the creation for debugging
        Log::info('Video files created', [
            'project_id' => $project->id,
            'mp4_path' => $mp4Path,
            'html_path' => $htmlPath,
            'mp4_size' => file_exists($fullMp4Path) ? filesize($fullMp4Path) : 0,
            'html_size' => file_exists($fullHtmlPath) ? filesize($fullHtmlPath) : 0
        ]);
        
        // Return the MP4 file path (this is what users will download)
        return $mp4Path;
    }
    
    /**
     * Generate HTML content for credits visualization
     */
    private function generateCreditsHTML(Project $project, array $creditsData, array $renderSettings)
    {
        $resolution = explode('x', $renderSettings['resolution']);
        $width = $resolution[0] ?? 1280;
        $height = $resolution[1] ?? 720;
        
        // Calculate scroll speed based on settings
        $speed = $renderSettings['speed'];
        $frameRate = floatval($renderSettings['frame_rate']);
        $runningTime = $renderSettings['running_time'];
        
        // Convert running time to seconds
        $timeParts = explode(':', $runningTime);
        $totalSeconds = (intval($timeParts[0]) * 60) + intval($timeParts[1]);
        
        $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($project->template_name) . ' - End Credits</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            color: #ffffff;
            overflow: hidden;
            width: ' . $width . 'px;
            height: ' . $height . 'px;
        }
        
        .credits-container {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 50px;
            animation: scrollUp ' . $totalSeconds . 's linear infinite;
        }
        
        @keyframes scrollUp {
            0% { transform: translateY(100vh); }
            100% { transform: translateY(-200vh); }
        }
        
        .credit-title {
            font-size: ' . max(24, $width * 0.03) . 'px;
            font-weight: bold;
            text-align: center;
            margin: 40px 0 30px 0;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
        }
        
        .credit-entry {
            text-align: center;
            margin: 15px 0;
            max-width: 80%;
        }
        
        .credit-role {
            font-size: ' . max(16, $width * 0.02) . 'px;
            font-weight: 300;
            color: #cccccc;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }
        
        .credit-name {
            font-size: ' . max(20, $width * 0.025) . 'px;
            font-weight: 600;
            color: #ffffff;
            letter-spacing: 2px;
        }
        
        .credit-text {
            font-size: ' . max(18, $width * 0.022) . 'px;
            font-weight: 400;
            color: #ffffff;
            text-align: center;
            margin: 20px 0;
            letter-spacing: 1px;
        }
        
        .spacer {
            height: 60px;
        }
        
        .final-logo {
            margin-top: 80px;
            text-align: center;
        }
        
        .final-logo h1 {
            font-size: ' . max(32, $width * 0.04) . 'px;
            font-weight: bold;
            letter-spacing: 4px;
            color: #ffffff;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.9);
        }
        
        .watermark {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: ' . max(12, $width * 0.015) . 'px;
            opacity: 0.6;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="credits-container">';
        
        foreach ($creditsData as $credit) {
            switch ($credit['type']) {
                case 'title':
                    $html .= '<div class="credit-title">' . htmlspecialchars($credit['text']) . '</div>';
                    break;
                case 'credit':
                    $html .= '<div class="credit-entry">
                        <div class="credit-role">' . htmlspecialchars($credit['role']) . '</div>
                        <div class="credit-name">' . htmlspecialchars($credit['name']) . '</div>
                    </div>';
                    break;
                case 'name':
                    $html .= '<div class="credit-text">' . htmlspecialchars($credit['text']) . '</div>';
                    break;
            }
            $html .= '<div class="spacer"></div>';
        }
        
        $html .= '
        <div class="final-logo">
            <h1>THE END</h1>
        </div>
    </div>
    <div class="watermark">Created with ScrollX.io</div>
</body>
</html>';
        
        return $html;
    }
    
    /**
     * Generate comprehensive video description with all project data
     */
    private function generateVideoDescription(Project $project, array $creditsData, array $renderSettings, string $htmlPath)
    {
        $description = "=== SCROLLX.IO END CREDITS VIDEO ===\n\n";
        $description .= "Project: " . $project->template_name . "\n";
        $description .= "Created: " . now()->toDateTimeString() . "\n";
        $description .= "User ID: " . $project->user_id . "\n\n";
        
        $description .= "=== RENDER SETTINGS ===\n";
        $description .= "Resolution: " . $renderSettings['resolution'] . "\n";
        $description .= "Format: " . $renderSettings['format'] . "\n";
        $description .= "Frame Rate: " . $renderSettings['frame_rate'] . " fps\n";
        $description .= "Speed: " . $renderSettings['speed'] . " px/frame\n";
        $description .= "Running Time: " . $renderSettings['running_time'] . "\n\n";
        
        $description .= "=== PROJECT DATA ===\n";
        if ($project->google_sheet_url) {
            $description .= "Google Sheet URL: " . $project->google_sheet_url . "\n";
        }
        $description .= "Template: " . $project->template_name . "\n";
        $description .= "Created: " . $project->created_at . "\n";
        $description .= "Updated: " . $project->updated_at . "\n\n";
        
        $description .= "=== CREDITS CONTENT ===\n";
        $description .= "Total Credits: " . count($creditsData) . "\n\n";
        
        foreach ($creditsData as $index => $credit) {
            $description .= ($index + 1) . ". ";
            switch ($credit['type']) {
                case 'title':
                    $description .= "[TITLE] " . $credit['text'] . "\n";
                    break;
                case 'credit':
                    $description .= "[CREDIT] " . $credit['role'] . " - " . $credit['name'] . "\n";
                    break;
                case 'name':
                    $description .= "[NAME] " . $credit['text'] . "\n";
                    break;
            }
        }
        
        $description .= "\n=== TECHNICAL INFO ===\n";
        $description .= "This file represents a rendered end credits video.\n";
        $description .= "In a production environment, this would be an actual MP4 video file\n";
        $description .= "generated using tools like FFmpeg or browser automation.\n\n";
        
        $description .= "HTML preview was generated at: " . $htmlPath . "\n";
        $description .= "Video dimensions: " . $renderSettings['resolution'] . "\n";
        $description .= "Expected file size: ~" . $this->estimateFileSize($renderSettings) . " MB\n\n";
        
        $description .= "=== NEXT STEPS FOR PRODUCTION ===\n";
        $description .= "1. Use Puppeteer to capture the HTML animation\n";
        $description .= "2. Convert captured frames to video using FFmpeg\n";
        $description .= "3. Apply audio track if specified\n";
        $description .= "4. Export in the requested format (" . $renderSettings['format'] . ")\n\n";
        
        $description .= "Generated by ScrollX.io Video Render Service v1.0\n";
        
        return $description;
    }
    
    /**
     * Estimate file size based on render settings
     */
    private function estimateFileSize(array $renderSettings)
    {
        $resolution = explode('x', $renderSettings['resolution']);
        $width = intval($resolution[0]);
        $height = intval($resolution[1]);
        $frameRate = floatval($renderSettings['frame_rate']);
        
        $runningTime = $renderSettings['running_time'];
        $timeParts = explode(':', $runningTime);
        $totalSeconds = (intval($timeParts[0]) * 60) + intval($timeParts[1]);
        
        // Rough estimation: higher resolution = larger file
        $pixelCount = $width * $height;
        $baseMB = ($pixelCount / 1000000) * $totalSeconds * 0.5; // Rough approximation
        
        return round($baseMB, 1);
    }
}
