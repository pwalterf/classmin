<?php

declare(strict_types=1);

use App\Models\Payment;

test('to array', function () {
    $payment = Payment::factory()->create()->refresh();

    expect(array_keys($payment->toArray()))->toBe([
        'id',
        'amount',
        'currency',
        'credits_purchased',
        'paid_at',
        'comments',
        'enrollment_id',
        'created_at',
        'updated_at',
    ]);
});
