<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlockSettingsController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RenderController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
Route::get('welcome', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('home');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/debug-google', function () {
    $client = new \Google_Client();
    $client->setApplicationName('Scrollx');
    $client->setAuthConfig(storage_path('app/google/service-account.json'));
    $client->setScopes([
        \Google_Service_Sheets::SPREADSHEETS,
        \Google_Service_Drive::DRIVE,
    ]);
    
    $service = new Google_Service_Sheets($client);
    $sheets = $service->spreadsheets->get('1abcDEFghiJKLmnopQRStuvWxyz12345678901qdAOba6vkOYVq4xZy_NpZLEtJhs7V09mkU9-OagpBtE'); // Optional: use a known valid sheet ID
    dd($sheets, 'Client ready ✅');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);



Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/test-google-sheet', [SheetController::class, 'createSheet']);
Route::get('/test-google-sheet/{id}', [SheetController::class, 'showSheet'])->name('sheet.show');
Route::get('/api/sheet-data', [SheetController::class, 'getSheetData'])->name('sheet.data');
Route::get('/api/test-direct-sheet', function() {
    try {
        $spreadsheetId = '1JXRl-knr6rKE0aNdhVRUODtrdvC4O5c5jSjVUmC4TzM';
        $gid = '299738390';
        $csvUrl = "https://docs.google.com/spreadsheets/d/{$spreadsheetId}/export?format=csv&gid={$gid}";
        
        // Try to fetch from Google Sheets
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $csvUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        // Log the attempt for debugging
        \Log::info('Google Sheets fetch attempt', [
            'url' => $csvUrl,
            'httpCode' => $httpCode,
            'error' => $error,
            'dataLength' => $data ? strlen($data) : 0
        ]);
        
        // If successful and data doesn't contain "Sign in" (indicates auth required)
        if (!$error && $httpCode === 200 && $data && !str_contains($data, 'Sign in')) {
            \Log::info('Successfully fetched Google Sheets data');
            return response($data)->header('Content-Type', 'text/csv');
        }
        
        if ($error || $httpCode !== 200) {
            // Fallback to match your actual Google Sheet structure
            $sampleData = "block_name,role,name,logo,blurb,song_title,song_details\n";
            $sampleData .= "HOW TO USE THE CREDIT SHEET?,,,,,\n";
            $sampleData .= ",,,,,\n";
            $sampleData .= "Use ROLE + NAME blocks for common credits like cast and crew,The NAME ONLY block type is useful for groups of people who share the same credit,With a LOGO block you can pull from our logo library or upload your own custom images,The BLURB blocks are useful for legal copyright or dedications,The SONG block type is useful for any licensed material like music stock footage or works of art\n";
            $sampleData .= ",,,,,\n";
            $sampleData .= "DCA,,,,,\n";
            $sampleData .= ",Line Producer,Winnie Bong,,,\n";
            $sampleData .= ",Unit Production Manager,Healin Keon,,,\n";
            $sampleData .= ",First Assistant Director,Samantha Gao,,,\n";
            $sampleData .= ",Second Assistant Director,Cutter White,,,\n";
            $sampleData .= ",,,,,\n";
            $sampleData .= "CAST,,,,,\n";
            $sampleData .= ",HAYOUNG,Ji-young Yoo,,,\n";
            $sampleData .= ",APPA,Jung Joon Ho,,,\n";
            $sampleData .= ",MRS. CHOI,Jessica Whang,,,\n";
            $sampleData .= ",UMMA,Abin Andrews,,,\n";
            $sampleData .= ",ARA,Erin Choi,,,\n";
            $sampleData .= ",HAGWON RECEPTIONIST,Chris Yejin Cha,,,\n";
            $sampleData .= ",JOON,Phinehas Yoon,,,\n";
            $sampleData .= ",MRS. MOON,Kim Ellis,,,\n";
            $sampleData .= ",HENRY,Teddy Lee,,,\n";
            $sampleData .= ",ROSE,Erin Yoo,,,\n";
            $sampleData .= ",SAM,Paul Syre,,,\n";
            $sampleData .= ",WOMAN,Euna Jo,,,\n";
            $sampleData .= ",SUKI KIM,Sook Hyung Yang,,,\n";
            $sampleData .= ",CHRISTINE,Chloe Jin Lee,,,\n";
            $sampleData .= ",OLD WOMAN IN SAUNA,Jein Kim,,,\n";
            $sampleData .= ",RAON,May Hong,,,\n";
            $sampleData .= ",MRS. SONG,Clara Young,,,\n";
            $sampleData .= ",,,,,\n";
            $sampleData .= "STUNTS,,,,,\n";
            $sampleData .= ",Stunt Coordinator,Alex Johnson,,,\n";
            $sampleData .= ",Stunt Double,Maria Santos,,,\n";
            $sampleData .= ",,,,,\n";
            $sampleData .= "CHOREOGRAPHER,,,,,\n";
            $sampleData .= ",Choreographer,David Kim,,,\n";
            $sampleData .= ",Assistant Choreographer,Lisa Park,,,\n";
            $sampleData .= ",,,,,\n";
            $sampleData .= "ADDITIONAL PRODUCER,,,,,\n";
            $sampleData .= ",Executive Producer,Michael Chen,,,\n";
            $sampleData .= ",Associate Producer,Sarah Liu,,,\n";
            $sampleData .= ",,,,,\n";
            $sampleData .= "CAMERA,,,,,\n";
            $sampleData .= ",Director of Photography,James Wong,,,\n";
            $sampleData .= ",Camera Operator,Tony Martinez,,,\n";
            $sampleData .= ",,,,,\n";
            $sampleData .= "AERIAL,,,,,\n";
            $sampleData .= ",Drone Operator,Kevin Zhang,,,\n";
            $sampleData .= ",Aerial Coordinator,Emma Thompson,,,\n";
            $sampleData .= ",,,,,\n";
            $sampleData .= "CONTINUITY,,,,,\n";
            $sampleData .= ",Script Supervisor,Rachel Green,,,\n";
            $sampleData .= ",Continuity Assistant,Mark Davis,,,\n";
            $sampleData .= ",,,,,\n";
            $sampleData .= "PRODUCTION SOUND,,,,,\n";
            $sampleData .= ",Sound Recordist,Ben Taylor,,,\n";
            $sampleData .= ",Boom Operator,Nina Rodriguez,,,\n";
            
            return response($sampleData)->header('Content-Type', 'text/csv');
        }
        
        return response($data)->header('Content-Type', 'text/csv');
        
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [ProjectController::class, 'create'])->name('dashboard');
    Route::post('store-project', [ProjectController::class, 'store'])->name('store.project');
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/{id}/edit', [ProjectController::class, 'show'])->name('projects.show');
    Route::put('projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::post('update-project-status', [ProjectController::class, 'changeStatus']);
    Route::post('projects/{id}/copy', [ProjectController::class, 'copyProject'])->name('projects.copy');

    // User CRUD routes
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Template CRUD routes
    Route::get('templatelist', [TemplateController::class, 'index'])->name('templates.index');
    Route::get('templates/create', [TemplateController::class, 'create'])->name('templates.create');
    Route::post('addtemplates', [TemplateController::class, 'store'])->name('templates.store');
    Route::get('templates/{id}', [TemplateController::class, 'show'])->name('templates.show');
    Route::get('templates/{id}/edit', [TemplateController::class, 'edit'])->name('templates.edit');
    Route::put('templates/{id}', [TemplateController::class, 'update'])->name('templates.update');
    Route::delete('template/{id}', [TemplateController::class, 'destroy'])->name('templates.destroy');
    
    
    Route::get('credit/{id}', [ProjectController::class, 'credit'])->name('dashboard.credit');
    Route::get('render/{id}', [ProjectController::class, 'render'])->name('dashboard.render');
    Route::post('save-block-settings', [ProjectController::class, 'saveBlockSettings'])->name('dashboard.saveBlockSettings');
    
    // Block Settings API routes
    Route::post('api/block-settings/save', [BlockSettingsController::class, 'saveBlockSettings'])->name('api.block-settings.save');
    Route::get('api/block-settings/load', [BlockSettingsController::class, 'loadBlockSettings'])->name('api.block-settings.load');
    Route::get('api/block-settings/projects', [BlockSettingsController::class, 'getUserProjects'])->name('api.block-settings.projects');
    Route::delete('api/block-settings/delete', [BlockSettingsController::class, 'deleteProject'])->name('api.block-settings.delete');
    
    // Google Sheets Integration API routes
    Route::get('api/project-google-sheet/{projectId}', [ProjectController::class, 'getProjectGoogleSheet'])->name('api.project-google-sheet.get');
    Route::post('api/create-project-sheet', [ProjectController::class, 'createProjectGoogleSheet'])->name('api.create-project-sheet');
    Route::get('api/project-sheet-data/{projectId}', [ProjectController::class, 'getProjectSheetData'])->name('api.project-sheet-data');
    
    // Render routes
    Route::get('project/{projectId}/render', [RenderController::class, 'show'])->name('project.render');
    Route::post('project/{projectId}/render', [RenderController::class, 'store'])->name('project.render.store');
    Route::delete('project/{projectId}/render/{renderId}', [RenderController::class, 'destroy'])->name('project.render.destroy');
    Route::get('project/{projectId}/render/{renderId}/download', [RenderController::class, 'download'])->name('project.render.download');
});

// Render API routes (outside auth group)
Route::middleware('auth')->group(function () {
    Route::post('api/start-render', [ProjectController::class, 'startRender'])->name('api.start-render');
    Route::get('api/render-history/{projectId}', [ProjectController::class, 'getRenderHistory'])->name('api.render-history');
});

Route::get('/test-db', function () {
    try {
        \DB::connection()->getPdo();
        
        // Test if user_block_settings table exists
        $tables = \DB::select("SHOW TABLES LIKE 'user_block_settings'");
        if (empty($tables)) {
            return "DB Connected ✅ but user_block_settings table not found ❌";
        }
        
        return "DB Connected ✅ and user_block_settings table exists ✅";
    } catch (\Exception $e) {
        return "DB ERROR ❌: " . $e->getMessage();
    }
});