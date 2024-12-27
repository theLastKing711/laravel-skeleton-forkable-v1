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

                Route::prefix('tests')
                    ->group(function () {
                        Route::get('', [ExampleController::class, 'index']);
                        Route::get('{id}', [ExampleController::class, 'show_item']);

                        Route::get('queryParameters', [ExampleController::class, 'get_query_parameters']);

                        Route::post('post_json', [ExampleController::class, 'post_json']);


                        Route::patch('{id}', [ExampleController::class, 'patch_json']);
                        Route::delete('{id}', [ExampleController::class, 'delete_json']);

                    });

            });

        Route::prefix('auth')->group(function () {
            Route::post('login', [AuthController::class, 'login']);
            Route::post('logout', [AuthController::class, 'logout']);
        });

    });
