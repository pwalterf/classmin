<?php

declare(strict_types=1);

namespace App\Enums;

enum CreditTransactionType: string
{
    case PURCHASE = 'purchase';
    case USE = 'use';
    case ADJUSTMENT = 'adjustment';
    case REFUND = 'refund';

    /**
     * Get all transaction types as an array.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get the label for the transaction type.
     */
    public function label(): string
    {
        return match ($this) {
            self::PURCHASE => 'Compra',
            self::USE => 'Uso',
            self::ADJUSTMENT => 'Ajuste',
            self::REFUND => 'Reembolso',
        };
    }

    /**
     * Get the color associated with the transaction type.
     */
    public function color(): string
    {
        return match ($this) {
            self::PURCHASE => 'green',
            self::USE => 'blue',
            self::ADJUSTMENT => 'yellow',
            self::REFUND => 'red',
        };
    }
}
