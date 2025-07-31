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
