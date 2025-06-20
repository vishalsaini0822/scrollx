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

// Route::get('login', function () {
//     return view('login');
// })->name('login');

// Route::get('register', function () {
//     return view('register');
// });

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);



Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);



Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [ProjectController::class, 'create'])->name('dashboard');
    Route::post('store-project', [ProjectController::class, 'store'])->name('store.project');
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/{id}/edit', [ProjectController::class, 'show'])->name('projects.show');
    Route::put('projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::post('update-project-status', [ProjectController::class, 'changeStatus']);
    Route::post('projects/{id}/copy', [ProjectController::class, 'copyProject'])->name('projects.copy');
    Route::get('/test-google-sheet', [SheetController::class, 'createSheet']);
    Route::get('/test-google-sheet/{id}', [SheetController::class, 'showSheet'])->name('sheet.show');

    // User CRUD routes
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Template CRUD routes
    Route::get('templates', [TemplateController::class, 'index'])->name('templates.index');
    Route::get('templates/create', [TemplateController::class, 'create'])->name('templates.create');
    Route::post('templates', [TemplateController::class, 'store'])->name('templates.store');
    Route::get('templates/{id}', [TemplateController::class, 'show'])->name('templates.show');
    Route::get('templates/{id}/edit', [TemplateController::class, 'edit'])->name('templates.edit');
    Route::put('templates/{id}', [TemplateController::class, 'update'])->name('templates.update');
    Route::delete('templates/{id}', [TemplateController::class, 'destroy'])->name('templates.destroy');
    
    
    Route::get('credit', [ProjectController::class, 'credit'])->name('dashboard.credit');
});

Route::get('/test-db', function () {
    try {
        \DB::connection()->getPdo();
        return "DB Connected ✅";
    } catch (\Exception $e) {
        return "DB ERROR ❌: " . $e->getMessage();
    }
});