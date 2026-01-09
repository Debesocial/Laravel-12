<?php

use Illuminate\Support\Facades\Route;
use Modules\Organizational\Http\Controllers\OrganizationalController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('organizationals', OrganizationalController::class)->names('organizational');
});
