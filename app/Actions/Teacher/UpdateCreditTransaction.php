<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\CreditTransaction;
use Illuminate\Support\Facades\DB;

final readonly class UpdateCreditTransaction
{
    /**
     * UpdateCreditTransaction constructor.
     */
    public function __construct(
        private UpdateNewerTransactions $updateNewerTransactions,
        private UpdateEnrollmentCredits $updateEnrollmentCredits,
    ) {}

    /**
     * Execute the action.
     */
    public function handle(CreditTransaction $originalTransaction, CreditTransaction $updatedTransaction): CreditTransaction
    {
        return DB::transaction(function () use ($originalTransaction, $updatedTransaction): CreditTransaction {
            $originalTransaction->fill([
                'transacted_at' => $updatedTransaction->transacted_at,
                'type' => $updatedTransaction->type,
                'credits' => $updatedTransaction->credits,
                'description' => $updatedTransaction->balance,
            ]);

            if ($originalTransaction->isDirty()) {
                if ($originalTransaction->isDirty('credits')) {
                    $creditsDiff = $updatedTransaction->credits - $originalTransaction->getOriginal('credits');

                    $originalTransaction->fill([
                        'balance' => $originalTransaction->balance + $creditsDiff,
                    ]);

                    $this->updateNewerTransactions->handle($originalTransaction, $creditsDiff);
                    $this->updateEnrollmentCredits->handle($originalTransaction->enrollment, $creditsDiff);
                }
                $originalTransaction->save();
            }

            return $originalTransaction;
        });
    }
}
