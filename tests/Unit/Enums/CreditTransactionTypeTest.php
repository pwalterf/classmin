<?php

declare(strict_types=1);

use App\Enums\CreditTransactionType;

test('credit transaction types', function () {
    $types = CreditTransactionType::getTypes();

    expect($types)->toHaveCount(4);
    expect($types)->toContain(CreditTransactionType::Purchase->value);
    expect($types)->toContain(CreditTransactionType::Use->value);
    expect($types)->toContain(CreditTransactionType::Adjustment->value);
    expect($types)->toContain(CreditTransactionType::Refund->value);
});
