<?php

declare(strict_types=1);

namespace App\Enums;

use JsonSerializable;

enum AttendanceStatus: string implements JsonSerializable
{
    case PRESENT = 'present';
    case ABSENT = 'absent';
    case LATE = 'late';
    case EXCUSED = 'excused';

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
            self::PRESENT => 'Presente',
            self::ABSENT => 'Ausente',
            self::LATE => 'Tarde',
            self::EXCUSED => 'Justificado',
        };
    }

    /**
     * Get the color associated with the status.
     */
    public function color(): string
    {
        return match ($this) {
            self::PRESENT => 'green',
            self::ABSENT => 'red',
            self::LATE => 'yellow',
            self::EXCUSED => 'blue',
        };
    }

    /**
     * Get the JSON representation of the status.
     */
    public function jsonSerialize(): mixed
    {
        return [
            'value' => $this->value,
            'label' => $this->label(),
            'color' => $this->color(),
        ];
    }
}
