<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Enums\CreditTransactionType;
use App\Models\CreditTransaction;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

final readonly class CreatePayment
{
    /**
     * CreatePayment constructor.
     */
    public function __construct(
        private CreateCreditTransaction $createCreditTransaction,
    ) {}

    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $paymentData
     */
    public function handle(array $paymentData): Payment
    {
        return DB::transaction(function () use ($paymentData) {
            $payment = Payment::create([
                'amount' => $paymentData['amount'],
                'currency' => $paymentData['currency'],
                'credits_purchased' => $paymentData['credits_purchased'],
                'paid_at' => $paymentData['paid_at'],
                'comments' => $paymentData['comments'] ?? null,
                'enrollment_id' => $paymentData['enrollment_id'],
            ]);

            $creditTransaction = new CreditTransaction([
                'transacted_at' => $payment->paid_at,
                'type' => CreditTransactionType::PURCHASE,
                'credits' => $payment->credits_purchased,
                'description' => 'Purchase of credits'.($payment->comments ? ": {$payment->comments}" : ''),
                'enrollment_id' => $payment->enrollment_id,
                'transactable_type' => Payment::class,
                'transactable_id' => $payment->id,
            ]);

            $this->createCreditTransaction->handle($creditTransaction);

            return $payment;
        });
    }
}
