<?php

declare(strict_types=1);

use App\Models\Enrollment;
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

test('belongs to enrollment', function () {
    $payment = Payment::factory()->create()->refresh();

    expect($payment->enrollment)->toBeInstanceOf(Enrollment::class);
});

test('has many credit transactions', function () {
    $payment = Payment::factory()->hasCreditTransactions(3)->create();

    expect($payment->creditTransactions)->toHaveCount(3);
});
