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
