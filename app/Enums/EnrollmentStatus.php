<?php

declare(strict_types=1);

namespace App\Enums;

enum EnrollmentStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Dropped = 'dropped';
    case Completed = 'completed';

    /**
     * Get all statuses as an array.
     *
     * @return array<int, string>
     */
    public static function getStatuses(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get labels for each status.
     *
     * @return array<string, string>
     */
    public static function getLabels(): array
    {
        return [
            self::Active->value => 'Activo',
            self::Inactive->value => 'Inactivo',
            self::Dropped->value => 'Abandonado',
            self::Completed->value => 'Completado',
        ];
    }
}
