<?php

declare(strict_types=1);

namespace App\Enums;

use JsonSerializable;

enum EnrollmentStatus: string implements JsonSerializable
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DROPPED = 'dropped';
    case COMPLETED = 'completed';

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
            self::DROPPED => 'Abandonado',
            self::COMPLETED => 'Completado',
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
            self::DROPPED => 'red',
            self::COMPLETED => 'blue',
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
