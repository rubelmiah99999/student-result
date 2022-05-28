<?php

use App\Http\Controllers\StudentController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware('is_admin')->group(function(){
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('admin/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('admin.logout');
    Route::resource('/students', StudentController::class);
});