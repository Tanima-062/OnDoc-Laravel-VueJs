<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\DeleteProfileController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\Product\BookmarkController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    Route::group(['middleware' => ['guest', 'throttle:60,1'] ], function () {
        Route::post('login', LoginController::class);

        //Forgot password
        Route::post('forgot-password', [ForgotPasswordController::class, 'sendPasswordResetOtp']);
        Route::post('forgot-password/verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
        Route::post('forgot-password/update-password', [ForgotPasswordController::class, 'updatePassword']);

        //Register
        // Route::post('register', [RegistrationController::class, 'store']);
        // Route::post('/check-user', [RegistrationController::class, 'checkUser']);
        // Route::post('verify-otp', [RegistrationController::class, 'verifyOtp']);
        // Route::post('resend-otp', [RegistrationController::class, 'resendOtp']);

    });

    Route::group(['middleware' =>    ['auth:appusers']], function () {
        Route::get('me', [UserController::class, 'me']);
        Route::post('logout', LogoutController::class);
        Route::post('current-password/check', [UserController::class, 'passwordCheck']);

        Route::put('update-profile', [UserController::class, 'update']);
        Route::put('update-email/request-otp', [UserController::class, 'sendEmailChangeOtpMail']);

        Route::post('reset-password', [UserController::class, 'resetPassword']);
        Route::post('reset-password/verify-otp', [UserController::class, 'verifyResendPasswordOtp']);
        Route::post('reset-password/resend-otp', [UserController::class, 'resendResendPasswordOtp']);
        Route::put('update-password', [UserController::class, 'updatePassword']);


        // Route::get('bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
        // Route::post('bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');
        // Route::delete('bookmarks/{bookmark}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
        Route::apiResource('bookmarks', BookmarkController::class)->except(['update']);

        // Route::get('search-users', [SearchController::class, 'serachUserAndStore']);
        // Route::get('user-profile/{user:id}', [ProfileController::class, 'show']);


        //Delete Account

        // Route::delete('delete-request', [DeleteProfileController::class, 'deleteRequest']);
        // Route::post('delete-request/verify-otp', [DeleteProfileController::class, 'verifyOtp']);
        // Route::post('delete-request/resend-otp', [DeleteProfileController::class, 'resendOtp']);
        // Route::delete('delete-account', [DeleteProfileController::class, 'deleteAccount']);

    });

});
