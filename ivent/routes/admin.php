<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Symfony\Component\HttpKernel\Profiler\Profile;

/**
 *
 * Routes for Admin & Employees
 *
 */



Route::group([
    'prefix' => 'admin',
    "as" => "admin.",
    'middleware' => ['auth'],

], function () {
    Route::get(
        '/',
        function () {
            // return redirect()->route('admin.dashboard.index');

        }
    )->name('home');
});
