<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;

test('to array', function () {
    $enrollment = Enrollment::factory()->create()->refresh();

    expect(array_keys($enrollment->toArray()))->toBe([
        'id',
        'status',
        'enrolled_at',
        'credits',
        'discount_pct',
        'user_id',
        'course_id',
        'created_at',
        'updated_at',
    ]);
});

test('belongs to a user', function () {
    $enrollment = Enrollment::factory()->create();

    expect($enrollment->user)->toBeInstanceOf(User::class);
});

test('belongs to a course', function () {
    $enrollment = Enrollment::factory()->create();

    expect($enrollment->course)->toBeInstanceOf(Course::class);
});

test('has many attendances', function () {
    $enrollment = Enrollment::factory()->hasAttendances(3)->create();

    expect($enrollment->attendances)->toHaveCount(3);
});

test('has many payments', function () {
    $enrollment = Enrollment::factory()->hasPayments(3)->create();

    expect($enrollment->payments)->toHaveCount(3);
});

test('has many credit transactions', function () {
    $enrollment = Enrollment::factory()->hasCreditTransactions(3)->create();

    expect($enrollment->creditTransactions)->toHaveCount(3);
});
