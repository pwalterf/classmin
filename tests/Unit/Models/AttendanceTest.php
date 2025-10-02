<?php

declare(strict_types=1);

use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Lesson;

test('to array', function () {
    $attendance = Attendance::factory()->create()->refresh();

    expect(array_keys($attendance->toArray()))->toBe([
        'id',
        'status',
        'notes',
        'lesson_id',
        'enrollment_id',
        'created_at',
        'updated_at',
    ]);
});

test('belongs to an enrollment', function () {
    $attendance = Attendance::factory()->create();

    expect($attendance->enrollment)->toBeInstanceOf(Enrollment::class);
});

test('belongs to a lesson', function () {
    $attendance = Attendance::factory()->create();

    expect($attendance->lesson)->toBeInstanceOf(Lesson::class);
});
