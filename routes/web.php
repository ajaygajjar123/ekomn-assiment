<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\OAuthController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/install', [OAuthController::class, 'install'])->name('install');
Route::get('/auth/callback', [OAuthController::class, 'callback'])->name('auth.callback');
Route::get('/app', [AppController::class, 'index'])->name('app.home');