<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Enums\CreditTransactionType;
use App\Models\CreditTransaction;
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
                    $originalTransaction = new CreditTransaction([
                        'transacted_at' => $payment->getOriginal('paid_at'),
                        'type' => CreditTransactionType::PURCHASE,
                        'credits' => $payment->getOriginal('credits_purchased'),
                        'enrollment_id' => $payment->enrollment_id,
                    ]);
                    $updatedTransaction = new CreditTransaction([
                        'transacted_at' => $payment->paid_at,
                        'type' => CreditTransactionType::PURCHASE,
                        'credits' => $payment->credits_purchased,
                        'enrollment_id' => $payment->enrollment_id,
                    ]);
                    $this->updateCreditTransaction->handle($originalTransaction, $updatedTransaction);
                }

                $payment->save();
            }

            return $payment;
        });
    }
}
