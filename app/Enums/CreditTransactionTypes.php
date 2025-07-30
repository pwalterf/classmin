<?php

declare(strict_types=1);

namespace App\Enums;

enum CreditTransactionTypes: string
{
    case Purchase = 'purchase';
    case Use = 'use';
    case Adjustment = 'adjustment';
    case Refund = 'refund';

    /**
     * Get all transaction types as an array.
     *
     * @return array<int, string>
     */
    public static function getTypes(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get labels for each transaction type.
     *
     * @return array<string, string>
     */
    public static function getLabels(): array
    {
        return [
            self::Purchase->value => 'Compra',
            self::Use->value => 'Uso',
            self::Adjustment->value => 'Ajuste',
            self::Refund->value => 'Reembolso',
        ];
    }
}
