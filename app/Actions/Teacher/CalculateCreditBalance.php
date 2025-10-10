<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\CreditTransaction;
use Illuminate\Support\Facades\DB;

final readonly class CalculateCreditBalance
{
    /**
     * Execute the action.
     */
    public function handle(CreditTransaction $creditTransaction): int
    {
        return DB::transaction(function () use ($creditTransaction): int {
            $lastTransaction = CreditTransaction::query()
                ->where('enrollment_id', $creditTransaction->enrollment_id)
                ->where('transacted_at', '<=', $creditTransaction->transacted_at)
                ->orderByDesc('transacted_at')
                ->orderByDesc('id')
                ->first();

            $lastBalance = $lastTransaction->balance ?? 0;

            return $lastBalance + $creditTransaction->credits;
        });
    }
}
