<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

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
            $this->deleteCreditTransaction->handle($payment->creditTransaction);

            $payment->delete();
        });
    }
}
