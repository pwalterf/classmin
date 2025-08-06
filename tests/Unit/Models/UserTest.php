<?php

declare(strict_types=1);

use App\Models\Teacher;
use App\Models\User;

test('to array', function () {
    $user = User::factory()->create()->refresh();

    expect(array_keys($user->toArray()))->toBe([
        'id',
        'first_name',
        'last_name',
        'email',
        'email_verified_at',
        'status',
        'created_at',
        'updated_at',
    ]);
});

test('has one teacher', function () {
    $user = User::factory()->hasTeacher()->create();

    expect($user->teacher)->toBeInstanceOf(Teacher::class);
});
