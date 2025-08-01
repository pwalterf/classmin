<?php

declare(strict_types=1);

namespace App\Enums;

enum UserPermission: string
{
    case VIEW_USERS = 'view_users';
    case MANAGE_USERS = 'manage_users';
    case VIEW_TEACHERS = 'view_teachers';
    case MANAGE_TEACHERS = 'manage_teachers';
    case VIEW_STUDENTS = 'view_students';
    case MANAGE_STUDENTS = 'manage_students';
    case VIEW_COURSES = 'view_courses';
    case MANAGE_COURSES = 'manage_courses';
    case VIEW_COURSE_PRICES = 'view_course_prices';
    case MANAGE_COURSE_PRICES = 'manage_course_prices';
    case VIEW_ENROLLMENTS = 'view_enrollments';
    case MANAGE_ENROLLMENTS = 'manage_enrollments';
    case VIEW_LESSONS = 'view_lessons';
    case MANAGE_LESSONS = 'manage_lessons';
    case VIEW_ATTENDANCES = 'view_attendances';
    case MANAGE_ATTENDANCES = 'manage_attendances';
    case VIEW_PAYMENTS = 'view_payments';
    case MANAGE_PAYMENTS = 'manage_payments';
    case VIEW_CREDIT_TRANSACTIONS = 'view_credit_transactions';
    case MANAGE_CREDIT_TRANSACTIONS = 'manage_credit_transactions';
    case VIEW_REPORTS = 'view_reports';

    /**
     * Get all permissions as an array.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the label for the permission.
     */
    public function label(): string
    {
        return match ($this) {
            self::VIEW_USERS => 'Ver Usuarios',
            self::MANAGE_USERS => 'Gestionar Usuarios',
            self::VIEW_TEACHERS => 'Ver Profesores',
            self::MANAGE_TEACHERS => 'Gestionar Profesores',
            self::VIEW_STUDENTS => 'Ver Estudiantes',
            self::MANAGE_STUDENTS => 'Gestionar Estudiantes',
            self::VIEW_COURSES => 'Ver Cursos',
            self::MANAGE_COURSES => 'Gestionar Cursos',
            self::VIEW_COURSE_PRICES => 'Ver Precios de Cursos',
            self::MANAGE_COURSE_PRICES => 'Gestionar Precios de Cursos',
            self::VIEW_ENROLLMENTS => 'Ver Inscripciones',
            self::MANAGE_ENROLLMENTS => 'Gestionar Inscripciones',
            self::VIEW_LESSONS => 'Ver Lecciones',
            self::MANAGE_LESSONS => 'Gestionar Lecciones',
            self::VIEW_ATTENDANCES => 'Ver Asistencias',
            self::MANAGE_ATTENDANCES => 'Gestionar Asistencias',
            self::VIEW_PAYMENTS => 'Ver Pagos',
            self::MANAGE_PAYMENTS => 'Gestionar Pagos',
            self::VIEW_CREDIT_TRANSACTIONS => 'Ver Transacciones de Crédito',
            self::MANAGE_CREDIT_TRANSACTIONS => 'Gestionar Transacciones de Crédito',
            self::VIEW_REPORTS => 'Ver Informes',
        };
    }
}
