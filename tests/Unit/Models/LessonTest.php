<?php

declare(strict_types=1);

use App\Models\Lesson;

test('to array', function () {
    $lesson = Lesson::factory()->create()->refresh();

    expect(array_keys($lesson->toArray()))->toBe([
        'id',
        'notes',
        'student_page',
        'workbook_page',
        'taught_at',
        'course_id',
        'created_at',
        'updated_at',
    ]);
});
