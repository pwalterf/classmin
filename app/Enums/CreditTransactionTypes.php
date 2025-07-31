<?php

declare(strict_types=1);

namespace App\Enums;

enum CreditTransactionTypes: string
{
    case Purchase = 'compra';
    case Use = 'uso';
    case Adjustment = 'ajuste';
    case Refund = 'reembolso';

    /**
     * Get all transaction types as an array.
     *
     * @return array<int, string>
     */
    public static function getTypes(): array
    {
        return array_column(self::cases(), 'value');
    }
}
