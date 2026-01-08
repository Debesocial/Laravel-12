<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// ==============================
// PUBLIC AREA (TANPA LOGIN)
// ==============================
Route::get('/', function () {
    return view('welcome');
});

// ==============================
// DASHBOARD (LOGIN REQUIRED)
// ==============================
Route::get('/dashboard', function () {
    return view('pages.dashboard');
})->middleware(['auth', 'permission:view dashboard'])->name('dashboard');

// ==============================
// PROFILE (AUTH USER)
// ==============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================
// ADMIN AREA (ROLE: admin)
// RBAC: Pastikan role & permission sudah sesuai di Spatie
// ==============================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Roles Management
    Route::get('/roles', function () {
        return view('admin.roles');
    })->name('roles')->middleware('permission:manage roles');

    // Permissions Management
    Route::get('/permissions', function () {
        return view('admin.permissions');
    })->name('permissions')->middleware('permission:manage permissions');

    // User Assignment / User Management
    Route::get('/assign', function () {
        return view('admin.users');
    })->name('assign')->middleware('permission:manage users');

    // Action Logs (Trigger: route('action-logs'))
    Route::get('/action-logs', function () {
        return view('admin.action-logs');
    })->name('action-logs')->middleware('permission:view logs');
});

// ==============================
// APPROVAL AREA (MULTI-ROLE)
// ==============================
Route::middleware(['auth', 'permission:approve document'])->get('/approval', function () {
    return view('approval.index');
})->name('approval.index');

// ==============================
// AUTH ROUTES
// ==============================
require __DIR__.'/auth.php';