<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\PasswordResetController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);



Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');

// Route::get('/reset-password', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
// Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');



Route::get('/test-db', function () {
    try {
        \DB::connection()->getPdo();
        return "DB Connected ✅";
    } catch (\Exception $e) {
        return "DB ERROR ❌: " . $e->getMessage();
    }
});