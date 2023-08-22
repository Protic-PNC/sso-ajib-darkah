<?php

use App\Http\Controllers\Api\UserContoller;
use App\Http\Controllers\Auth\LogoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/auth')->middleware(['auth:api', 'scope:view-user'])->group(function () {
    Route::get('/user', [UserContoller::class, 'authUser']);
});

Route::prefix('auth')->middleware(['auth:api'])->group(function () {
    Route::get('/logout', [UserContoller::class, 'authLogout']);
});

Route::middleware(['auth:api'])->group(function () {
    Route::get('/user', [UserContoller::class, 'user']);
    Route::get('/user/{id}', [UserContoller::class, 'user']);
});

