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
        private UpdateNewerTransactions $updateNewerTransactions,
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
                'description' => $creditTransaction->description ?? null,
                'enrollment_id' => $creditTransaction->enrollment_id,
                'transactable_type' => $creditTransaction->transactable_type ?? null,
                'transactable_id' => $creditTransaction->transactable_id ?? null,
            ]);

            // check and update newer transactions
            $this->updateNewerTransactions->handle($creditTransaction, $creditTransaction->credits);
            $this->updateEnrollmentCredits->handle($enrollment, $creditTransaction->credits);

            return $creditTransaction;
        });
    }
}
