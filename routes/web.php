<?php

use App\Enum\Auth\RolesEnum;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\User\Auth\ChangePasswordController;
use App\Http\Controllers\User\Auth\ChangePhoneNumberController;
use App\Http\Controllers\User\Auth\GetUserPhoneNumberController;
use App\Http\Controllers\User\Auth\Login\AddPhoneNumberLoginStepController;
use App\Http\Controllers\User\Auth\Login\LoginController;
use App\Http\Controllers\User\Auth\Registeration\AddPhoneNumberRegisterationStepController;
use App\Http\Controllers\User\Auth\Registeration\RegisterController;
use Illuminate\Support\Facades\Route;

Route::prefix('files')
    ->middleware(
        [
            'api',
            'auth:sanctum',
            RolesEnum::oneOfRolesMiddleware(RolesEnum::ADMIN, RolesEnum::STORE, RolesEnum::USER),
        ]
    )
    ->group(function () {
        Route::post('', [FileController::class, 'store']);
        Route::delete('{public_id}', [FileController::class, 'delete']);
        Route::get('cloudinary-presigned-urls', [FileController::class, 'getTestCloudinaryPresignedUrls']);
        Route::post('cloudinary-notifications-url', [FileController::class, 'saveTemporaryUploadedImageToDBOnCloudinaryUploadNotificationSuccess']);
    });

Route::prefix('admins')
    ->middleware(['api'])
    ->group(function () {
        $adminRole = RolesEnum::ADMIN->value;

        // must be logged in after making request to /sanctum and obtaining token to send here
        Route::middleware(['auth:sanctum', "role:{$adminRole}"])
            // auth:sanctum check if user is logged in (middleware('auth')),
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

        // NEEDS CSRF TOKEN, EVEN THOUGH IT'S OUTSIDE auth:sanctum middleware
        Route::prefix('auth')->group(function () {
            Route::post('login', [AuthController::class, 'login']);
            Route::post('logout', [AuthController::class, 'logout']);
        });

    });

Route::prefix('users')
    ->middleware(['api'])
    ->group(function () {
        $userRole = RolesEnum::USER->value;

        // must be logged in after making request to /sanctum and obtaining token to send here
        Route::middleware(
            [
                'auth:sanctum',
                RolesEnum::oneOfRolesMiddleware(RolesEnum::USER, RolesEnum::ADMIN, RolesEnum::STORE),
            ]
        )
            // auth:sanctum check if user is logged in (middleware('auth')),
            ->group(function () {

                Route::prefix('auth')->group(function () {

                    Route::get('get-user-phone-number', GetUserPhoneNumberController::class);
                    Route::patch('change-password', ChangePasswordController::class);
                    Route::patch('change-phone-number', ChangePhoneNumberController::class);

                });

            });

        Route::prefix('auth')->group(function () {

            Route::prefix('login')->group(function () {

                Route::post('phone-number-step', AddPhoneNumberLoginStepController::class);
                Route::post('login', LoginController::class);

            });

            Route::prefix('registeration')->group(function () {

                Route::post('phone-number-step', AddPhoneNumberRegisterationStepController::class);
                Route::post('register', RegisterController::class);

            });

        });

    });
