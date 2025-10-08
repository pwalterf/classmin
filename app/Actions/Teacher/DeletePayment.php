<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Enums\CreditTransactionType;
use App\Models\CreditTransaction;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

final readonly class DeletePayment
{
    /**
     * DeleteAttendance constructor.
     */
    public function __construct(
        private DeleteCreditTransaction $deleteCreditTransaction,
    ) {}

    /**
     * Execute the action.
     */
    public function handle(Payment $payment): void
    {
        DB::transaction(function () use ($payment): void {
            $creditTransaction = new CreditTransaction([
                'enrollment_id' => $payment->enrollment_id,
                'transacted_at' => $payment->paid_at,
                'type' => CreditTransactionType::PURCHASE,
            ]);

            $this->deleteCreditTransaction->handle($creditTransaction);

            $payment->delete();
        });
    }
}
