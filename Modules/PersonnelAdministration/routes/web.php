<?php

use Illuminate\Support\Facades\Route;
use Modules\PersonnelAdministration\Http\Controllers\PersonnelAdministrationController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('personneladministrations', PersonnelAdministrationController::class)->names('personneladministration');
});
