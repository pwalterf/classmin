<?php

declare(strict_types=1);

namespace App\Enums;

enum CourseStatus: string
{
    case Active = 'activo';
    case Inactive = 'inactivo';
    case Completed = 'completado';
    case Paused = 'pausado';
    case Cancelled = 'cancelado';
    case Holiday = 'vacaciones';

    /**
     * Get all statuses as an array.
     *
     * @return array<int, string>
     */
    public static function getStatuses(): array
    {
        return array_column(self::cases(), 'value');
    }
}
