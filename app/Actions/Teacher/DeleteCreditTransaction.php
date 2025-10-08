<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\CreditTransaction;
use Illuminate\Support\Facades\DB;

final readonly class DeleteCreditTransaction
{
    /**
     * DeleteCreditTransaction constructor.
     */
    public function __construct(
        private UpdateEnrollmentCredits $updateEnrollmentCredits,
    ) {}

    /**
     * Execute the action.
     */
    public function handle(CreditTransaction $creditTransaction): void
    {
        DB::transaction(function () use ($creditTransaction): void {
            if (! $creditTransaction->id) {
                $creditTransaction = CreditTransaction::query()
                    ->where('enrollment_id', $creditTransaction->enrollment_id)
                    ->where('transacted_at', $creditTransaction->transacted_at)
                    ->where('type', $creditTransaction->type)
                    ->firstOrFail();
            }

            $this->updateEnrollmentCredits->handle($creditTransaction->enrollment, -$creditTransaction->credits);

            $creditTransaction->delete();
        });
    }
}
