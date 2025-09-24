<?php

declare(strict_types=1);

use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Teacher\EnrollmentController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Middleware\TeacherMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([TeacherMiddleware::class, 'auth', 'verified'])->prefix('teacher')->group(function () {
    Route::resource('courses', CourseController::class);
    Route::resource('students', StudentController::class);
    Route::resource('enrollments', EnrollmentController::class);
})->name('teacher.');
