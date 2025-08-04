<?php

declare(strict_types=1);

use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Database\QueryException;

test('to array', function () {
    $course = Course::factory()->create()->refresh();

    expect(array_keys($course->toArray()))->toBe([
        'id',
        'title',
        'description',
        'started_at',
        'status',
        'schedule',
        'teacher_id',
        'created_at',
        'updated_at',
    ]);
});

test('belongs to a teacher', function () {
    $course = Course::factory()->create();

    expect($course->teacher)->toBeInstanceOf(Teacher::class);
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

test('two courses with the same title can exist for different teachers', function () {
    $teacher1 = Teacher::factory()->create();
    $teacher2 = Teacher::factory()->create();

    Course::factory()->for($teacher1)->create(['title' => 'Unique Course Title']);
    Course::factory()->for($teacher2)->create(['title' => 'Unique Course Title']);
})->throws(QueryException::class);

test('same teacher may not have two courses with the same title', function () {
    $teacher = Teacher::factory()->create();
    Course::factory()
        ->for($teacher)
        ->count(2)
        ->create([
            'title' => 'Unique Course Title',
        ]);
})->throws(QueryException::class);
