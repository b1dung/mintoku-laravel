<?php

use Illuminate\Support\Facades\Route;
use Mintoku\UserAuth\Http\Controllers\LoginController;
use Mintoku\UserAuth\Http\Controllers\UserJobController;

/*
|--------------------------------------------------------------------------
| User Authentication & Job Management Routes
|--------------------------------------------------------------------------
|
| This file handles the authentication flow for users and provides 
| CRUD operations for their specific job postings.
|
*/

Route::group(["middleware" => ["web"]], function () {

    /**
     * Guest Routes
     * Only accessible to users who are not logged in.
     */
    Route::middleware('guest')->group(function () {
        // Display the login form
        Route::get("user/login", [LoginController::class, "showLoginForm"])->name("user.login");

        // Handle login submission
        Route::post("user/login", [LoginController::class, "login"])->name("user.login.post");
    });

    /**
     * Authenticated Routes
     * Protected by the 'auth' middleware.
     */
    Route::group(["middleware" => ["auth"]], function () {

        // Handle user logout
        Route::post("user/logout", [LoginController::class, "logout"])->name("logout");

        /**
         * User Job Management (CRUD)
         * Prefix: user/jobs | Name Alias: user.job.*
         */
        Route::group(["prefix" => "user/jobs", "as" => "user.job."], function () {

            // List all jobs belonging to the authenticated user
            Route::get('/', [UserJobController::class, 'index'])->name('index');

            // Show the form to create a new job
            Route::get('create', [UserJobController::class, 'create'])->name('create');

            // Store a newly created job in the database
            Route::post('store', [UserJobController::class, 'store'])->name('store');

            // Show the form to edit an existing job
            Route::get('{job}/edit', [UserJobController::class, 'edit'])->name('edit');

            // Update an existing job in the database
            Route::put('{job}/update', [UserJobController::class, 'update'])->name('update');

            // Remove a job from the database
            Route::delete('{job}/delete', [UserJobController::class, 'destroy'])->name('destroy');
        });
    });
});
