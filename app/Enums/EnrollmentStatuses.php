<?php

declare(strict_types=1);

namespace App\Enums;

enum EnrollmentStatuses: string
{
    case Active = 'activo';
    case Inactive = 'inactivo';
    case Dropped = 'abandonado';
    case Completed = 'completado';

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
