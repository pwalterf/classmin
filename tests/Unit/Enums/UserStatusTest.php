<?php

declare(strict_types=1);

use App\Enums\UserStatus;

test('user status values', function () {
    $expectedValues = [
        'active',
        'inactive',
        'paused',
    ];

    expect(UserStatus::values())->toEqual($expectedValues);
});

test('course status labels', function () {
    expect(UserStatus::ACTIVE->label())->toBe('Activo');
    expect(UserStatus::INACTIVE->label())->toBe('Inactivo');
    expect(UserStatus::PAUSED->label())->toBe('Pausado');
});

test('course status colors', function () {
    expect(UserStatus::ACTIVE->color())->toBe('green');
    expect(UserStatus::INACTIVE->color())->toBe('gray');
    expect(UserStatus::PAUSED->color())->toBe('yellow');
});
