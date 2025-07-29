<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProjectController;
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
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $csvUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
        
        $data = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error || $httpCode !== 200) {
            // Fallback to sample data for testing
            $sampleData = "Instructions,,,\n";
            $sampleData .= "Leave blank rows between blocks,,,\n";
            $sampleData .= "block_name,role,name,\n";
            $sampleData .= ",,,\n";
            $sampleData .= "CAST,,,\n";
            $sampleData .= ",Actor,John Doe,\n";
            $sampleData .= ",Actress,Jane Smith,\n";
            $sampleData .= ",Director,Mike Johnson,\n";
            $sampleData .= ",,,\n";
            $sampleData .= "CREW,,,\n";
            $sampleData .= ",Producer,Sarah Wilson,\n";
            $sampleData .= ",Cinematographer,Tom Brown,\n";
            $sampleData .= ",Editor,Lisa Garcia,\n";
            $sampleData .= ",,,\n";
            $sampleData .= "MUSIC,,,\n";
            $sampleData .= ",Composer,David Lee,\n";
            $sampleData .= ",Sound Designer,Emily Chen,\n";
            $sampleData .= ",,,\n";
            $sampleData .= "SPECIAL THANKS,,,\n";
            $sampleData .= ",Executive Producer,Robert Taylor,\n";
            $sampleData .= ",Location Manager,Maria Rodriguez,\n";
            
            return response($sampleData)->header('Content-Type', 'text/csv');
        }
        
        return response($data)->header('Content-Type', 'text/csv');
        
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
// Route::post('/save-block-settings', [SheetController::class, 'saveBlockSettings'])->name('save.block.settings');

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
    Route::post('save-block-settings', [ProjectController::class, 'saveBlockSettings'])->name('dashboard.saveBlockSettings');
});

Route::get('/test-db', function () {
    try {
        \DB::connection()->getPdo();
        return "DB Connected ✅";
    } catch (\Exception $e) {
        return "DB ERROR ❌: " . $e->getMessage();
    }
});