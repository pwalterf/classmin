<?php

declare(strict_types=1);

use App\Enums\UserPermission;

test('user permissions enum values', function () {
    $expectedValues = [
        'view_users',
        'manage_users',
        'view_teachers',
        'manage_teachers',
        'view_students',
        'manage_students',
        'view_courses',
        'manage_courses',
        'view_course_prices',
        'manage_course_prices',
        'view_enrollments',
        'manage_enrollments',
        'view_lessons',
        'manage_lessons',
        'view_attendances',
        'manage_attendances',
        'view_payments',
        'manage_payments',
        'view_credit_transactions',
        'manage_credit_transactions',
        'view_reports',
    ];

    expect(UserPermission::values())->toBe($expectedValues);
});

test('user permissions enum labels', function () {
    expect(UserPermission::VIEW_USERS->label())->toBe('Ver Usuarios');
    expect(UserPermission::MANAGE_USERS->label())->toBe('Gestionar Usuarios');
    expect(UserPermission::VIEW_TEACHERS->label())->toBe('Ver Profesores');
    expect(UserPermission::MANAGE_TEACHERS->label())->toBe('Gestionar Profesores');
    expect(UserPermission::VIEW_STUDENTS->label())->toBe('Ver Estudiantes');
    expect(UserPermission::MANAGE_STUDENTS->label())->toBe('Gestionar Estudiantes');
    expect(UserPermission::VIEW_COURSES->label())->toBe('Ver Cursos');
    expect(UserPermission::MANAGE_COURSES->label())->toBe('Gestionar Cursos');
    expect(UserPermission::VIEW_COURSE_PRICES->label())->toBe('Ver Precios de Cursos');
    expect(UserPermission::MANAGE_COURSE_PRICES->label())->toBe('Gestionar Precios de Cursos');
    expect(UserPermission::VIEW_ENROLLMENTS->label())->toBe('Ver Inscripciones');
    expect(UserPermission::MANAGE_ENROLLMENTS->label())->toBe('Gestionar Inscripciones');
    expect(UserPermission::VIEW_LESSONS->label())->toBe('Ver Lecciones');
    expect(UserPermission::MANAGE_LESSONS->label())->toBe('Gestionar Lecciones');
    expect(UserPermission::VIEW_ATTENDANCES->label())->toBe('Ver Asistencias');
    expect(UserPermission::MANAGE_ATTENDANCES->label())->toBe('Gestionar Asistencias');
    expect(UserPermission::VIEW_PAYMENTS->label())->toBe('Ver Pagos');
    expect(UserPermission::MANAGE_PAYMENTS->label())->toBe('Gestionar Pagos');
    expect(UserPermission::VIEW_CREDIT_TRANSACTIONS->label())->toBe('Ver Transacciones de Crédito');
    expect(UserPermission::MANAGE_CREDIT_TRANSACTIONS->label())->toBe('Gestionar Transacciones de Crédito');
    expect(UserPermission::VIEW_REPORTS->label())->toBe('Ver Informes');
});
