<?php

use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\LoginController;
use Illuminate\Support\Facades\Route;

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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'showform'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('post_login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');