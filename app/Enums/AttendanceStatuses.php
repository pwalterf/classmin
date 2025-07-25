<?php

declare(strict_types=1);

namespace App\Enums;

enum AttendanceStatuses: string
{
    case Present = 'present';
    case Absent = 'absent';
    case Late = 'late';
    case Excused = 'excused';

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
            self::Present->value => 'Presente',
            self::Absent->value => 'Ausente',
            self::Late->value => 'Tarde',
            self::Excused->value => 'Justificado',
        ];
    }
}
