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
        'created_at',
        'updated_at',
    ]);
});

test('belongs to an enrollment', function () {
    $creditTransaction = CreditTransaction::factory()->create();

    expect($creditTransaction->enrollment)->toBeInstanceOf(Enrollment::class);
});
