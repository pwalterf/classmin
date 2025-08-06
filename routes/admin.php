<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => AdminMiddleware::class], function () {
    Route::resource('users', UserController::class);
    Route::resource('teachers', TeacherController::class);
});
