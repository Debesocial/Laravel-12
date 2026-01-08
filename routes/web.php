<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\AccessControl\UserManagementController;
use App\Http\Controllers\AccessControl\RoleManagementController;
use App\Http\Controllers\AccessControl\PermissionManagementController;
use App\Http\Controllers\AccessControl\ActionLogController;
use App\Http\Controllers\SystemSettings\ErrorLogController;
use App\Http\Controllers\SystemSettings\SystemConfigController;
use App\Http\Controllers\SystemSettings\SessionManagerController;
use App\Http\Controllers\SystemSettings\ResourceMonitoringController;
use App\Http\Controllers\SystemSettings\NotificationCenterController;

# PUBLIC (NO AUTH)
Route::get('/', fn () => view('welcome'))->name('homepage');

# GOOGLE OAUTH
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

# AUTHENTICATED AREA (ALL ROLES)
Route::middleware(['auth'])->group(function () {
    # DASHBOARD (ALL ROLES)
    Route::get('/dashboard', fn () => view('pages.dashboard'))->middleware(['permission:view dashboard', 'active-permission:view dashboard'])->name('dashboard');
    # PROFILE (ALL ROLES)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    # IMPERSONATE (SPECIAL CASE)
    Route::post('/impersonate/stop', [ImpersonateController::class, 'stop'])->withoutMiddleware(['role', 'permission', 'active-permission'])->name('impersonate.stop');
    Route::post('/impersonate/{user}', [ImpersonateController::class, 'start'])->name('impersonate.start');
});

# ADMIN AREA (ADMIN + SUPERADMIN)
Route::middleware(['auth', 'role:admin|superadmin'])->group(function () {
    # USER MANAGEMENT
    Route::get('/users', [UserManagementController::class, 'index'])->middleware(['permission:manage users', 'active-permission:manage users'])->name('users');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('users.toggle-status');
});

# SUPER ADMIN ONLY AREA
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    # SYSTEM CONFIG
    Route::get('/system-config', [SystemConfigController::class, 'index'])->name('system-config');
    Route::put('/system-config', [SystemConfigController::class, 'update'])->name('system-config.update');
    # SESSION MANAGER
    Route::get('/session-manager', [SessionManagerController::class, 'index'])->name('session-manager');
    Route::delete('/session-manager/{id}', [SessionManagerController::class, 'destroy'])->name('session-manager.terminate');
    # RESOURCE MONITORING
    Route::get('/resource-monitoring', [ResourceMonitoringController::class, 'index'])->name('resource-monitoring');
    # ACTION LOGS
    Route::get('/action-logs', [ActionLogController::class, 'index'])->middleware(['permission:view action logs', 'active-permission:view action logs'])->name('action-logs');
    # ERROR LOGS
    Route::get('/error-logs', [ErrorLogController::class, 'index'])->middleware(['permission:view error logs', 'active-permission:view error logs'])->name('error-logs');
    Route::get('/logs/download', [ErrorLogController::class, 'download'])->name('error-logs.download');
    Route::post('/logs/clear', [ErrorLogController::class, 'clear'])->name('error-logs.clear');
    # ROLE MANAGEMENT
    Route::get('/roles', [RoleManagementController::class, 'index'])->middleware(['permission:manage roles', 'active-permission:manage roles'])->name('roles');
    Route::post('/roles', [RoleManagementController::class, 'store'])->name('roles.store');
    Route::put('/roles/{id}', [RoleManagementController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{id}', [RoleManagementController::class, 'destroy'])->name('roles.destroy');
    Route::post('/roles/toggle-status', [RoleManagementController::class, 'toggleStatus'])->name('roles.toggle-status');
    # PERMISSION MANAGEMENT
    Route::get('/permissions', [PermissionManagementController::class, 'index'])->middleware(['permission:manage permissions', 'active-permission:manage permissions'])->name('permissions');
    Route::post('/permissions', [PermissionManagementController::class, 'store'])->name('permissions.store');
    Route::put('/permissions/{id}', [PermissionManagementController::class, 'update'])->name('permissions.update');
    Route::delete('/permissions/{id}', [PermissionManagementController::class, 'destroy'])->name('permissions.destroy');
    Route::post('/permissions/toggle-status', [PermissionManagementController::class, 'toggleStatus'])->name('permissions.toggle-status');
    # NOTIFICATION CENTER
    Route::get('/notification-center', [NotificationCenterController::class, 'index'])->name('notification-center.index');
    Route::post('/notification-center', [NotificationCenterController::class, 'store'])->name('notification-center.store');
    Route::patch('/notification-center/{notification}/read', [NotificationCenterController::class, 'markAsRead'])->name('notification-center.read');
    Route::delete('/notification-center/{notification}', [NotificationCenterController::class, 'destroy'])->name('notification-center.destroy');
});

# AUTH ROUTES
require __DIR__.'/auth.php';