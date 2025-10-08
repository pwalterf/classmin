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
        private CalculateCreditBalance $calculateCreditBalance,
        private UpdateEnrollmentCredits $updateEnrollmentCredits,
    ) {}

    /**
     * Execute the action.
     */
    public function handle(CreditTransaction $originalTransaction, CreditTransaction $updatedTransaction): CreditTransaction
    {
        return DB::transaction(function () use ($originalTransaction, $updatedTransaction) {
            if (! $originalTransaction->id) {
                $originalTransaction = CreditTransaction::query()
                    ->where('enrollment_id', $originalTransaction->enrollment_id)
                    ->where('transacted_at', $originalTransaction->transacted_at)
                    ->where('type', $originalTransaction->type)
                    ->firstOrFail();
            }

            $originalTransaction->fill([
                'transacted_at' => $updatedTransaction->transacted_at,
                'type' => $updatedTransaction->type,
                'credits' => $updatedTransaction->credits,
                'balance' => $this->calculateCreditBalance->handle($updatedTransaction),
            ]);

            if ($originalTransaction->isDirty()) {
                if ($originalTransaction->isDirty('balance')) {
                    $this->updateEnrollmentCredits->handle($originalTransaction->enrollment, $originalTransaction->balance - $originalTransaction->getOriginal('balance'));
                }
                $originalTransaction->save();
            }

            return $originalTransaction;
        });
    }
}
