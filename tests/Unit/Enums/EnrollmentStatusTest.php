<?php

declare(strict_types=1);

use App\Enums\EnrollmentStatus;

test('enrollment status values', function () {
    $expectedValues = [
        'active',
        'inactive',
        'dropped',
        'completed',
    ];

    expect(EnrollmentStatus::values())->toEqual($expectedValues);
});

test('enrollment status labels', function () {
    expect(EnrollmentStatus::ACTIVE->label())->toBe('Activo');
    expect(EnrollmentStatus::INACTIVE->label())->toBe('Inactivo');
    expect(EnrollmentStatus::DROPPED->label())->toBe('Abandonado');
    expect(EnrollmentStatus::COMPLETED->label())->toBe('Completado');
});

test('enrollment status colors', function () {
    expect(EnrollmentStatus::ACTIVE->color())->toBe('green');
    expect(EnrollmentStatus::INACTIVE->color())->toBe('gray');
    expect(EnrollmentStatus::DROPPED->color())->toBe('red');
    expect(EnrollmentStatus::COMPLETED->color())->toBe('blue');
});
