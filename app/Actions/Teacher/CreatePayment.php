<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;

final readonly class CreatePayment
{
    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $paymentData
     */
    public function handle(array $paymentData): Payment
    {
        return DB::transaction(fn () => Payment::create([
            'amount' => $paymentData['amount'],
            'currency' => $paymentData['currency'] ?? null,
            'credits_purchased' => $paymentData['credits_purchased'] ?? null,
            'paid_at' => $paymentData['paid_at'],
            'comments' => $paymentData['comments'],
            'enrollment_id' => $paymentData['enrollment_id'],
        ]));
    }
}
