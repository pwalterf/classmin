<?php

declare(strict_types=1);

namespace App\Enums;

enum CourseStatuses: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Completed = 'completed';
    case Paused = 'paused';
    case Cancelled = 'cancelled';
    case Holiday = 'holiday';

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
            self::Completed->value => 'Completado',
            self::Paused->value => 'Pausado',
            self::Cancelled->value => 'Cancelado',
            self::Holiday->value => 'Vacaciones',
        ];
    }
}
