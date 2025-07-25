<?php

declare(strict_types=1);

use App\Models\Enrollment;

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
