<?php

declare(strict_types=1);

use App\Enums\CreditTransactionType;

test('credit transaction type values', function () {
    $expectedValues = [
        'purchase',
        'use',
        'adjustment',
        'refund',
    ];

    expect(CreditTransactionType::values())->toEqual($expectedValues);
});

test('credit transaction type labels', function () {
    expect(CreditTransactionType::PURCHASE->label())->toBe('Compra');
    expect(CreditTransactionType::USE->label())->toBe('Uso');
    expect(CreditTransactionType::ADJUSTMENT->label())->toBe('Ajuste');
    expect(CreditTransactionType::REFUND->label())->toBe('Reembolso');
});

test('credit transaction type colors', function () {
    expect(CreditTransactionType::PURCHASE->color())->toBe('green');
    expect(CreditTransactionType::USE->color())->toBe('blue');
    expect(CreditTransactionType::ADJUSTMENT->color())->toBe('yellow');
    expect(CreditTransactionType::REFUND->color())->toBe('red');
});
