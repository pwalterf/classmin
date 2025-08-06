<?php

declare(strict_types=1);

use App\Models\Teacher;
use App\Models\User;

test('to array', function () {
    $teacher = Teacher::factory()->create()->refresh();

    expect(array_keys($teacher->toArray()))->toBe([
        'id',
        'bio',
        'user_id',
        'created_at',
        'updated_at',
    ]);
});

test('belongs to user', function () {
    $teacher = Teacher::factory()->create();

    expect($teacher->user)->toBeInstanceOf(User::class);
});

test('has many courses', function () {
    $teacher = Teacher::factory()->hasCourses(3)->create();

    expect($teacher->courses)->toHaveCount(3);
});
