<?php

use App\Enum\Auth\RolesEnum;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::prefix('files')
    ->middleware(['api'])
    ->group(function () {
        Route::get('', [FileController::class, 'index']);
        Route::post('', [FileController::class, 'store']);
    });

Route::prefix('admin')
    ->middleware(['api'])
    ->group(function () {
        $adminRole = RolesEnum::ADMIN->value;

        Route::middleware(['auth:sanctum', "role:{$adminRole}"])
            //auth:sanctum check if user is logged in (middleware('auth')),
            ->group(function () {

                Route::prefix('admin')
                    ->group(function () {
                        Route::get('', [ExampleController::class, 'index']);
                        Route::get('{id}', [ExampleController::class, 'show']);

                        Route::delete('{id}', [ExampleController::class, 'destroy']);
                        Route::patch('{id}', [ExampleController::class, 'update']);

                    });

            });

        Route::prefix('auth')->group(function () {
            Route::post('login', [AuthController::class, 'login']);
            Route::post('logout', [AuthController::class, 'logout']);
        });

    });
