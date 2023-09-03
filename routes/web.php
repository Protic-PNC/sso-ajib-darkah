<?php

use App\Http\Livewire\ClientSetting;
use App\Http\Livewire\Product;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Verify;
use App\Http\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Livewire\Branch;
use App\Http\Livewire\BranchStock;
use App\Http\Livewire\Category;
use App\Http\Livewire\ListPermissions;
use App\Http\Livewire\ListRoles;
use App\Http\Livewire\ListUsers;

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

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)
        ->name('login');

    Route::get('register', Register::class)
        ->name('register');
});

Route::get('password/reset', Email::class)
    ->name('password.request');

Route::get('password/reset/{token}', Reset::class)
    ->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('password/confirm', Confirm::class)
        ->name('password.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)
        ->middleware('signed')
        ->name('verification.verify');

    Route::get('logout', LogoutController::class)
        ->name('logout');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', Dashboard::class)->name('home');
    Route::get('/category', Category::class)->name('category');
    Route::get('/product', Product::class)->name('product');
    Route::get('/cabang', Branch::class)->name('cabang');
    Route::get('/cabang/{code}', BranchStock::class)->name('cabang.stock');

    Route::get('/users', ListUsers::class)->name('users');
    Route::get('/roles', ListRoles::class)->name('roles');
    Route::get('/permissions', ListPermissions::class)->name('permissions');
    Route::get('/client-setting', ClientSetting::class)->name('client.setting');
});
