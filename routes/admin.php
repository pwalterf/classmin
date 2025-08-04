<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\UserController;

Route::group(['prefix' => 'admin', 'middleware' => ['admin']], function () {
    Route::resource('users', UserController::class);
});
