<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhatsappController;
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
Route::middleware(['sso.login'])->group(function () {
    Route::get('/', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::post('/profile/update', [UserController::class, 'profileUpdate'])->name('profile.update');

    Route::get('/application', [ApplicationController::class, 'index'])->name('application.index');
    Route::get('/application/add', [ApplicationController::class, 'add'])->name('application.add');
    Route::post('/application/add', [ApplicationController::class, 'store'])->name('application.store');
    Route::get('/application/{id}/edit', [ApplicationController::class, 'edit'])->name('application.edit');
    Route::put('/application/{id}/edit', [ApplicationController::class, 'update'])->name('application.update');
    Route::delete('/application/{id}/destroy', [ApplicationController::class, 'destroy'])->name('application.destroy');

    Route::get('/role', [RoleController::class, 'index'])->name('role.index');
    Route::get('/role/add', [RoleController::class, 'add'])->name('role.add');
    Route::post('/role/add', [RoleController::class, 'store'])->name('role.store');
    Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
    Route::put('/role/{id}/edit', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/role/{id}/destroy', [RoleController::class, 'destroy'])->name('role.destroy');

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/add', [UserController::class, 'add'])->name('user.add');
    Route::post('/user/add', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}/edit', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}/destroy', [UserController::class, 'destroy'])->name('user.destroy');
    
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/setting/add', [SettingController::class, 'store'])->name('setting.store');
    Route::post('/setting/group/add', [SettingController::class, 'addGroup'])->name('setting.group.add');
    Route::put('/setting/group/{id}/update', [SettingController::class, 'updateGroup'])->name('setting.group.update');
    Route::delete('/setting/group/{id}/destroy', [SettingController::class, 'destroyGroup'])->name('setting.group.destroy');
    Route::put('/setting/{id}/edit', [SettingController::class, 'update'])->name('setting.update');
    Route::put('/setting/{id}/clear', [SettingController::class, 'clearFile'])->name('setting.clear');
    Route::delete('/setting/{id}/destroy', [SettingController::class, 'destroy'])->name('setting.destroy');

    Route::get('/whatsapp', [WhatsappController::class, 'index'])->name('whatsapp.index');
});