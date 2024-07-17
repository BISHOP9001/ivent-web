<?php

use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\EventSettingsController;
use App\Http\Controllers\Api\V1\FormFieldTemplateController;
use App\Http\Controllers\Api\V1\ParticipationController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\Api\V1\TicketController;
use Illuminate\Support\Facades\Route;

// Group user-related routes under a common prefix and controller
Route::group(
    ['prefix' => 'v1'],
    function () {
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::post('/register', [UserController::class, 'register']);
            Route::post('/login', [UserController::class, 'login']);
            Route::post('/password/reset', [UserController::class, 'resetPassword']);
        });

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
                Route::post('/logout', [UserController::class, 'logout']);
                Route::post('/password/update', [UserController::class, 'updatePassword']);
                Route::post('/delete', [UserController::class, 'destroy']);
                Route::post('/photo', [UserController::class, 'uploadPhoto']);
            });
            Route::get('/profile', [UserController::class, 'profile']);
            Route::post('/profile', [UserController::class, 'updateProfile']);
            // Events Routes
            Route::apiResource('events', EventController::class);
            Route::get('/events/{eventId}/check-participation', [ParticipationController::class, 'checkParticipation']);
            Route::post('/events/participation/code', [ParticipationController::class, 'participateWithAccessCode']);


            Route::apiResource('participations', ParticipationController::class);

            // Ticket Routes

            Route::apiResource('tickets', TicketController::class);
            Route::post('tickets/{ticket}/scan', [TicketController::class, 'scanTicket']);
            Route::apiResource('feedback', ReviewController::class);
            Route::get('/categories', [CategoryController::class, 'index']);
            Route::get('events/category/{categoryId}', [EventController::class, 'getEventsByCategoryId']);
            Route::get('/user/events/participating', [EventController::class, 'getParticipatingEvents']);




            // Event Settings Routes
            Route::get('event-settings/{eventId}', [EventSettingsController::class, 'getSettings']);

            // Form Field Template Routes
            Route::get('event-forms/{eventId}', [FormFieldTemplateController::class, 'getFormFields']);
            Route::post('event-forms/fill', [FormFieldTemplateController::class, 'fillForm']);
        });
    }
);
