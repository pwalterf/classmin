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
}
