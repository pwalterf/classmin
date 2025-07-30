<?php

declare(strict_types=1);

use App\Enums\CreditTransactionTypes;

test('credit transaction types', function () {
    $types = CreditTransactionTypes::getTypes();

    expect($types)->toHaveCount(4);
    expect($types)->toContain(CreditTransactionTypes::Purchase->value);
    expect($types)->toContain(CreditTransactionTypes::Use->value);
    expect($types)->toContain(CreditTransactionTypes::Adjustment->value);
    expect($types)->toContain(CreditTransactionTypes::Refund->value);
});

test('credit transaction type labels', function () {
    $labels = CreditTransactionTypes::getLabels();

    expect($labels)->toHaveCount(4);
    expect($labels[CreditTransactionTypes::Purchase->value])->toBe('Compra');
    expect($labels[CreditTransactionTypes::Use->value])->toBe('Uso');
    expect($labels[CreditTransactionTypes::Adjustment->value])->toBe('Ajuste');
    expect($labels[CreditTransactionTypes::Refund->value])->toBe('Reembolso');
});
