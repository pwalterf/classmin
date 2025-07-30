<?php

declare(strict_types=1);

use App\Models\CreditTransaction;
use App\Models\Enrollment;
use App\Models\Payment;

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

test('belongs to an enrollment', function () {
    $creditTransaction = CreditTransaction::factory()->create();

    expect($creditTransaction->enrollment)->toBeInstanceOf(Enrollment::class);
});

test('belongs to a payment', function () {
    $creditTransaction = CreditTransaction::factory()->create();

    expect($creditTransaction->payment)->toBeInstanceOf(Payment::class);
});
