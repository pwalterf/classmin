<?php

declare(strict_types=1);

namespace App\Enums;

enum CourseStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case COMPLETED = 'completed';
    case PAUSED = 'paused';
    case CANCELLED = 'cancelled';
    case HOLIDAY = 'holiday';

    /**
     * Get all statuses as an array.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the label for the status.
     */
    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Activo',
            self::INACTIVE => 'Inactivo',
            self::COMPLETED => 'Completado',
            self::PAUSED => 'Pausado',
            self::CANCELLED => 'Cancelado',
            self::HOLIDAY => 'Vacaciones',
        };
    }

    /**
     * Get the color associated with the status.
     */
    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'green',
            self::INACTIVE => 'gray',
            self::COMPLETED => 'blue',
            self::PAUSED => 'yellow',
            self::CANCELLED => 'red',
            self::HOLIDAY => 'orange',
        };
    }
}
