<?php

declare(strict_types=1);

use App\Models\CoursePrice;

test('to array', function () {
    $price = CoursePrice::factory()->create()->refresh();

    expect(array_keys($price->toArray()))->toBe([
        'id',
        'price',
        'currency',
        'started_at',
        'ended_at',
        'created_at',
        'updated_at',
        'course_id',
    ]);
});
