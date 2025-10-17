<?php

declare(strict_types=1);

use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Teacher\CoursePriceController;
use App\Http\Controllers\Teacher\CreditTransactionController;
use App\Http\Controllers\Teacher\EnrollmentController;
use App\Http\Controllers\Teacher\LessonController;
use App\Http\Controllers\Teacher\PaymentController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Middleware\TeacherMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([TeacherMiddleware::class, 'auth', 'verified'])->prefix('teacher')->group(function () {
    Route::resource('courses', CourseController::class);
    Route::resource('students', StudentController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('coursePrices', CoursePriceController::class);
    Route::resource('lessons', LessonController::class);
    Route::patch('attendances/update', [AttendanceController::class, 'update'])->name('attendances.update');
    Route::resource('payments', PaymentController::class);
    Route::post('creditTransactions/store', [CreditTransactionController::class, 'store'])->name('creditTransactions.store');
})->name('teacher.');
