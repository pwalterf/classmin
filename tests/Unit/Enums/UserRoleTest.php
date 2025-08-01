<?php

declare(strict_types=1);

use App\Enums\UserRole;

test('user role values', function () {
    $expectedValues = [
        'admin',
        'teacher',
        'student',
    ];

    expect(UserRole::values())->toEqual($expectedValues);
});

test('user role labels', function () {
    expect(UserRole::ADMIN->label())->toBe('Administrador');
    expect(UserRole::TEACHER->label())->toBe('Profesor');
    expect(UserRole::STUDENT->label())->toBe('Estudiante');
});
