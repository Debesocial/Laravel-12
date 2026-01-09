<?php

use Illuminate\Support\Facades\Route;
use Modules\PersonnelAdministration\Http\Controllers\PersonnelAdministrationController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('personneladministrations', PersonnelAdministrationController::class)->names('personneladministration');
});
