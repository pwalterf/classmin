<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;

final readonly class UpdatePayment
{
    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $paymentData
     */
    public function handle(Payment $payment, array $paymentData): Payment
    {
        return DB::transaction(function () use ($payment, $paymentData): Payment {
            $payment->fill($paymentData);

            if ($payment->isDirty()) {
                $payment->save();
            }

            return $payment;
        });
    }
}
