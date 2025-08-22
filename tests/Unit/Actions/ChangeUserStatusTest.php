<?php

declare(strict_types=1);

use App\Actions\Admin\ChangeUserStatus;
use App\Enums\UserStatus;
use App\Models\User;

test('admin can change user status', function () {
    $user = User::factory()->create([
        'status' => UserStatus::ACTIVE,
    ]);

    $user = app(ChangeUserStatus::class)->handle($user, UserStatus::PAUSED->value);

    expect($user->status)->toBe(UserStatus::PAUSED);
});
