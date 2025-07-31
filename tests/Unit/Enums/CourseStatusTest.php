<?php

declare(strict_types=1);

use App\Enums\CourseStatus;

test('course status values', function () {
    $expectedValues = [
        'active',
        'inactive',
        'completed',
        'paused',
        'cancelled',
        'holiday',
    ];

    expect(CourseStatus::values())->toEqual($expectedValues);
});

test('course status labels', function () {
    expect(CourseStatus::ACTIVE->label())->toBe('Activo');
    expect(CourseStatus::INACTIVE->label())->toBe('Inactivo');
    expect(CourseStatus::COMPLETED->label())->toBe('Completado');
    expect(CourseStatus::PAUSED->label())->toBe('Pausado');
    expect(CourseStatus::CANCELLED->label())->toBe('Cancelado');
    expect(CourseStatus::HOLIDAY->label())->toBe('Vacaciones');
});

test('course status colors', function () {
    expect(CourseStatus::ACTIVE->color())->toBe('green');
    expect(CourseStatus::INACTIVE->color())->toBe('gray');
    expect(CourseStatus::COMPLETED->color())->toBe('blue');
    expect(CourseStatus::PAUSED->color())->toBe('yellow');
    expect(CourseStatus::CANCELLED->color())->toBe('red');
    expect(CourseStatus::HOLIDAY->color())->toBe('orange');
});
