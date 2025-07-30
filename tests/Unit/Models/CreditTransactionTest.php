<?php

declare(strict_types=1);

use App\Models\CreditTransaction;

test('to array', function () {
    $creditTransaction = CreditTransaction::factory()->create()->refresh();

    expect(array_keys($creditTransaction->toArray()))->toBe([
        'id',
        'transacted_at',
        'type',
        'credits',
        'balance',
        'description',
        'enrollment_id',
        'payment_id',
        'created_at',
        'updated_at',
    ]);
});
