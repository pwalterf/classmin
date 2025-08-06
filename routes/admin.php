<?php

declare(strict_types=1);

use App\Actions\Admin\ChangeUserStatus;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => AdminMiddleware::class], function () {
    Route::post('admin/users/{id}/change-status', [ChangeUserStatus::class, 'changeStatus'])->name('admin.users.changeStatus');

    Route::resource('users', UserController::class);
    Route::resource('teachers', TeacherController::class);
});
