<?php

declare(strict_types=1);

use App\Models\Course;

test('to array', function () {
    $course = Course::factory()->create()->refresh();

    expect(array_keys($course->toArray()))->toBe([
        'id',
        'title',
        'description',
        'started_at',
        'status',
        'created_at',
        'updated_at',
    ]);
});

test('has many course prices', function () {
    $course = Course::factory()->hasPrices(3)->create();

    expect($course->prices)->toHaveCount(3);
});

test('has many enrollments', function () {
    $course = Course::factory()->hasEnrollments(3)->create();

    expect($course->enrollments)->toHaveCount(3);
});

test('has many lessons', function () {
    $course = Course::factory()->hasLessons(3)->create();

    expect($course->lessons)->toHaveCount(3);
});
