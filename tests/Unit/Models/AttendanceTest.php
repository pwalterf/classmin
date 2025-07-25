<?php

declare(strict_types=1);

use App\Models\Attendance;

test('to array', function () {
    $attendance = Attendance::factory()->create()->refresh();

    expect(array_keys($attendance->toArray()))->toBe([
        'id',
        'status',
        'notes',
        'registered_at',
        'lesson_id',
        'enrollment_id',
        'created_at',
        'updated_at',
    ]);
});
