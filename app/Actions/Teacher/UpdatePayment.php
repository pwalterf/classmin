<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;

final readonly class UpdatePayment
{
    /**
     * CreateAttendance constructor.
     */
    public function __construct(
        private UpdateCreditTransaction $updateCreditTransaction,
    ) {}

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
                if ($payment->isDirty('credits_purchased') || $payment->isDirty('paid_at')) {
                    $updatedTransaction = $payment->creditTransaction->replicate();
                    $updatedTransaction->fill([
                        'transacted_at' => $payment->paid_at,
                        'credits' => $payment->credits_purchased,
                    ]);
                    $this->updateCreditTransaction->handle($payment->creditTransaction, $updatedTransaction);
                }

                $payment->save();
            }

            return $payment;
        });
    }
}
