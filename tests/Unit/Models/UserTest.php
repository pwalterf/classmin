<?php

declare(strict_types=1);

test('to array', function () {
    $user = App\Models\User::factory()->create()->refresh();

    expect(array_keys($user->toArray()))->toBe([
        'id',
        'name',
        'email',
        'email_verified_at',
        'created_at',
        'updated_at',
    ]);
});

test('has many enrollments', function () {
    $user = App\Models\User::factory()->hasEnrollments(3)->create();

    expect($user->enrollments)->toHaveCount(3);
});
