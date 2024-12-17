<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Halaman logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Halaman login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'submitLogin'])->name('login.password');
Route::get('/login/otp', [AuthController::class, 'otp'])->name('login.otp');
Route::post('/login/otp', [AuthController::class, 'submitOtp'])->name('login.otp');
Route::post('/login/email', [AuthController::class, 'withEmail'])->name('login.email');
Route::post('/login/phone', [AuthController::class, 'withPhone'])->name('login.phone');

// Dashboard setelah login
Route::middleware(['auth'])->group(function () {
    Route::get('/', [PageController::class, 'dashboard'])->name('home');
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    
    // Rute lain untuk pengaturan akun
    Route::get('/my', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/change', [ProfileController::class, 'change'])->name('profile.change');
    Route::get('/profile/verifikasi', [ProfileController::class, 'verifikasi'])->name('verifikasi.index');
    Route::post('/profile/verifikasi/email', [ProfileController::class, 'verifikasiEmail'])->name('verifikasi.email');
    Route::post('/profile/verifikasi/phone', [ProfileController::class, 'verifikasiPhone'])->name('verifikasi.phone');
    Route::post('/profile/verifikasi/submit', [ProfileController::class, 'submitVerifikasi'])->name('verifikasi.send');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
});
