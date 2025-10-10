<?php

declare(strict_types=1);

use App\Models\CreditTransaction;
use App\Models\Enrollment;

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
        'transactable_type',
        'transactable_id',
        'created_at',
        'updated_at',
    ]);
});

test('belongs to enrollment', function () {
    $creditTransaction = CreditTransaction::factory()->create()->refresh();

    expect($creditTransaction->enrollment)->toBeInstanceOf(Enrollment::class);
});
