<?php

use Illuminate\Support\Facades\Route;
use Modules\Organizational\app\Http\Controllers\CompanyCodeController;
use Modules\Organizational\app\Http\Controllers\PersonnelAreaController;
use Modules\Organizational\app\Http\Controllers\PersonnelSubAreaController;
use Modules\Organizational\app\Http\Controllers\DivisionController;
use Modules\Organizational\app\Http\Controllers\DepartmentController;
use Modules\Organizational\app\Http\Controllers\SectionController;
use Modules\Organizational\app\Http\Controllers\UnitController;
use Modules\Organizational\app\Http\Controllers\SubUnitController;
use Modules\Organizational\app\Http\Controllers\PositionController;
use Modules\Organizational\app\Http\Controllers\JobLevelController;

/*
|--------------------------------------------------------------------------
| ORGANIZATIONAL MASTER DATA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('organizational')->group(function () {

/*
|--------------------------------------------------------------------------
| COMPANY CODE
|--------------------------------------------------------------------------
*/
Route::get('/company-codes', [CompanyCodeController::class, 'index'])
    ->middleware(['permission:view company codes', 'active-permission:view company codes'])
    ->name('company-codes');

Route::middleware(['permission:manage company codes', 'active-permission:manage company codes'])
    ->group(function () {

        Route::post('/company-codes', [CompanyCodeController::class, 'store'])
            ->name('organizational.company-codes.store');

        Route::put('/company-codes/{companyCode}', [CompanyCodeController::class, 'update'])
            ->name('organizational.company-codes.update');

        Route::delete('/company-codes/{companyCode}', [CompanyCodeController::class, 'destroy'])
            ->name('organizational.company-codes.destroy');

        Route::post('/company-codes/toggle-status', [CompanyCodeController::class, 'toggleStatus'])
            ->name('organizational.company-codes.toggle-status');
    });


    /*
    |--------------------------------------------------------------------------
    | PERSONNEL AREA
    |--------------------------------------------------------------------------
    */
    Route::get('/personnel-areas', [PersonnelAreaController::class, 'index'])
        ->middleware(['permission:view personnel areas', 'active-permission:view personnel areas'])
        ->name('organizational.personnel-areas');

    Route::middleware(['permission:manage personnel areas', 'active-permission:manage personnel areas'])->group(function () {
        Route::post('/personnel-areas', [PersonnelAreaController::class, 'store'])->name('organizational.personnel-areas.store');
        Route::put('/personnel-areas/{personnelArea}', [PersonnelAreaController::class, 'update'])->name('organizational.personnel-areas.update');
        Route::delete('/personnel-areas/{personnelArea}', [PersonnelAreaController::class, 'destroy'])->name('organizational.personnel-areas.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | PERSONNEL SUB AREA
    |--------------------------------------------------------------------------
    */
    Route::get('/personnel-sub-areas', [PersonnelSubAreaController::class, 'index'])
        ->middleware(['permission:view personnel sub areas', 'active-permission:view personnel sub areas'])
        ->name('organizational.personnel-sub-areas');

    Route::middleware(['permission:manage personnel sub areas', 'active-permission:manage personnel sub areas'])->group(function () {
        Route::post('/personnel-sub-areas', [PersonnelSubAreaController::class, 'store'])->name('organizational.personnel-sub-areas.store');
        Route::put('/personnel-sub-areas/{personnelSubArea}', [PersonnelSubAreaController::class, 'update'])->name('organizational.personnel-sub-areas.update');
        Route::delete('/personnel-sub-areas/{personnelSubArea}', [PersonnelSubAreaController::class, 'destroy'])->name('organizational.personnel-sub-areas.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ORGANIZATION STRUCTURE
    |--------------------------------------------------------------------------
    */
    Route::get('/divisions', [DivisionController::class, 'index'])
        ->middleware(['permission:view divisions', 'active-permission:view divisions'])
        ->name('organizational.divisions');

    Route::middleware(['permission:manage divisions', 'active-permission:manage divisions'])->group(function () {
        Route::post('/divisions', [DivisionController::class, 'store'])->name('organizational.divisions.store');
        Route::put('/divisions/{division}', [DivisionController::class, 'update'])->name('organizational.divisions.update');
        Route::delete('/divisions/{division}', [DivisionController::class, 'destroy'])->name('organizational.divisions.destroy');
    });

    Route::get('/departments', [DepartmentController::class, 'index'])
        ->middleware(['permission:view departments', 'active-permission:view departments'])
        ->name('organizational.departments');

    Route::middleware(['permission:manage departments', 'active-permission:manage departments'])->group(function () {
        Route::post('/departments', [DepartmentController::class, 'store'])->name('organizational.departments.store');
        Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('organizational.departments.update');
        Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('organizational.departments.destroy');
    });

    Route::get('/sections', [SectionController::class, 'index'])
        ->middleware(['permission:view sections', 'active-permission:view sections'])
        ->name('organizational.sections');

    Route::middleware(['permission:manage sections', 'active-permission:manage sections'])->group(function () {
        Route::post('/sections', [SectionController::class, 'store'])->name('organizational.sections.store');
        Route::put('/sections/{section}', [SectionController::class, 'update'])->name('organizational.sections.update');
        Route::delete('/sections/{section}', [SectionController::class, 'destroy'])->name('organizational.sections.destroy');
    });

    Route::get('/units', [UnitController::class, 'index'])
        ->middleware(['permission:view units', 'active-permission:view units'])
        ->name('organizational.units');

    Route::middleware(['permission:manage units', 'active-permission:manage units'])->group(function () {
        Route::post('/units', [UnitController::class, 'store'])->name('organizational.units.store');
        Route::put('/units/{unit}', [UnitController::class, 'update'])->name('organizational.units.update');
        Route::delete('/units/{unit}', [UnitController::class, 'destroy'])->name('organizational.units.destroy');
    });

    Route::get('/sub-units', [SubUnitController::class, 'index'])
        ->middleware(['permission:view sub units', 'active-permission:view sub units'])
        ->name('organizational.sub-units');

    Route::middleware(['permission:manage sub units', 'active-permission:manage sub units'])->group(function () {
        Route::post('/sub-units', [SubUnitController::class, 'store'])->name('organizational.sub-units.store');
        Route::put('/sub-units/{subUnit}', [SubUnitController::class, 'update'])->name('organizational.sub-units.update');
        Route::delete('/sub-units/{subUnit}', [SubUnitController::class, 'destroy'])->name('organizational.sub-units.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | POSITION & JOB LEVEL
    |--------------------------------------------------------------------------
    */
    Route::get('/positions', [PositionController::class, 'index'])
        ->middleware(['permission:view positions', 'active-permission:view positions'])
        ->name('organizational.positions');

    Route::middleware(['permission:manage positions', 'active-permission:manage positions'])->group(function () {
        Route::post('/positions', [PositionController::class, 'store'])->name('organizational.positions.store');
        Route::put('/positions/{position}', [PositionController::class, 'update'])->name('organizational.positions.update');
        Route::delete('/positions/{position}', [PositionController::class, 'destroy'])->name('organizational.positions.destroy');
    });

    Route::get('/job-levels', [JobLevelController::class, 'index'])
        ->middleware(['permission:view job levels', 'active-permission:view job levels'])
        ->name('organizational.job-levels');

    Route::middleware(['permission:manage job levels', 'active-permission:manage job levels'])->group(function () {
        Route::post('/job-levels', [JobLevelController::class, 'store'])->name('organizational.job-levels.store');
        Route::put('/job-levels/{jobLevel}', [JobLevelController::class, 'update'])->name('organizational.job-levels.update');
        Route::delete('/job-levels/{jobLevel}', [JobLevelController::class, 'destroy'])->name('organizational.job-levels.destroy');
    });

});
