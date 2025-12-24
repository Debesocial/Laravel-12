<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD (SEMUA USER LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'permission:view dashboard'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE (ALL AUTH USER)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
| - ROLE: admin
| - PERMISSION: manage users
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->middleware('permission:view dashboard')->name('dashboard');

        Route::resource('users', UserController::class)
            ->middleware('permission:manage users');
    });

/*
|--------------------------------------------------------------------------
| APPROVAL AREA (MULTI-ROLE READY)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'permission:approve document'])->group(function () {
    Route::get('/approval', function () {
        return view('approval.index');
    })->name('approval.index');
});

require __DIR__.'/auth.php';
