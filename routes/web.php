<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MonitoringController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect halaman utama ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk Login & Register
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

// Tambahkan rute baru untuk login Google
Route::post('/login/google-callback', [LoginController::class, 'handleGoogleCallback']);

// Route setelah login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/status', [MonitoringController::class, 'showHistory'])->name('status');
    Route::get('/settings', function () {
        return view('setting');
    })->name('settings');
    
    // Monitoring API routes
    Route::get('/monitoring/history', [MonitoringController::class, 'showHistory'])->name('monitoring.history');
    Route::post('/monitoring/store', [MonitoringController::class, 'storeHistory'])
        ->middleware('web')
        ->name('monitoring.store');
});