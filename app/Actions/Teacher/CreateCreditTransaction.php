<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\CreditTransaction;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

final readonly class CreateCreditTransaction
{
    /**
     * CreateCreditTransaction constructor.
     */
    public function __construct(
        private CalculateCreditBalance $calculateCreditBalance,
        private UpdateCreditTransaction $updateCreditTransaction,
        private UpdateEnrollmentCredits $updateEnrollmentCredits,
    ) {}

    /**
     * Execute the action.
     */
    public function handle(CreditTransaction $creditTransaction): CreditTransaction
    {
        return DB::transaction(function () use ($creditTransaction) {
            $enrollment = Enrollment::find($creditTransaction->enrollment_id);

            $creditTransaction = CreditTransaction::create([
                'transacted_at' => $creditTransaction->transacted_at,
                'type' => $creditTransaction->type,
                'credits' => $creditTransaction->credits,
                'balance' => $this->calculateCreditBalance->handle($creditTransaction),
                'enrollment_id' => $creditTransaction->enrollment_id,
            ]);

            $newerTransactions = CreditTransaction::query()
                ->where('enrollment_id', $creditTransaction->enrollment_id)
                ->where('transacted_at', '>', $creditTransaction->transacted_at)
                ->orderBy('transacted_at')
                ->orderBy('id')
                ->get();

            foreach ($newerTransactions as $transaction) {
                $this->updateCreditTransaction->handle($transaction, $transaction);
            }

            $this->updateEnrollmentCredits->handle($enrollment, $creditTransaction->credits);

            return $creditTransaction;
        });
    }
}
