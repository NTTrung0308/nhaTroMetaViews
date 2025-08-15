<?php

use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Clients\AboutController;
use App\Http\Controllers\Clients\ContactController as ClientsContactController;
use App\Http\Controllers\Clients\PolicyController;
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\LoginController;
use App\Http\Controllers\Clients\MemberController;
use App\Http\Controllers\Clients\NewsController;
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


Route::prefix('tin-tuc')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('news.users');
    Route::get('/{slug}', [NewsController::class, 'detail'])->name('news.users.detail');
});

Route::prefix('chinh-sach-bao-mat')->group(function(){
 Route::get('/{policy}/detail', [PolicyController::class, 'detail'])->name('policy.users.detail');
});
Route::prefix('lien-he')->group(function(){
 Route::get('/', [ClientsContactController::class, 'index'])->name('contact.users.index');
 Route::post('/store', [ClientsContactController::class, 'store'])->name('contact.users.store');
});

Route::prefix('thanh-vien')->group(function () {
    Route::get('/', [MemberController::class, 'index'])->name('members.users.index');
});
Route::prefix('gioi-thieu')->group(function () {
    Route::get('/', [AboutController::class, 'index'])->name('about.users.index');
});