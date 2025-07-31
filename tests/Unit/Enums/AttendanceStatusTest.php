<?php

declare(strict_types=1);

use App\Enums\AttendanceStatus;

test('attendance status values', function () {
    $expectedValues = [
        'present',
        'absent',
        'late',
        'excused',
    ];

    expect(AttendanceStatus::values())->toEqual($expectedValues);
});

test('attendance status labels', function () {
    expect(AttendanceStatus::PRESENT->label())->toBe('Presente');
    expect(AttendanceStatus::ABSENT->label())->toBe('Ausente');
    expect(AttendanceStatus::LATE->label())->toBe('Tarde');
    expect(AttendanceStatus::EXCUSED->label())->toBe('Justificado');
});

test('attendance status colors', function () {
    expect(AttendanceStatus::PRESENT->color())->toBe('green');
    expect(AttendanceStatus::ABSENT->color())->toBe('red');
    expect(AttendanceStatus::LATE->color())->toBe('yellow');
    expect(AttendanceStatus::EXCUSED->color())->toBe('blue');
});
