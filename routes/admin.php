<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserStatusController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => AdminMiddleware::class], function () {
    Route::get('users/statuses', [UserStatusController::class, 'getStatuses'])->name('users.statuses');
    Route::patch('users/{user}/change-status', [UserStatusController::class, 'changeStatus'])->name('users.changeStatus');

    Route::resource('users', UserController::class);
    Route::resource('teachers', TeacherController::class)->only(['index', 'store', 'update', 'destroy']);
})->name('admin.');
