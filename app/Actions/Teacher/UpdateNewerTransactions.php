<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\CreditTransaction;
use Illuminate\Support\Facades\DB;

final readonly class UpdateNewerTransactions
{
    /**
     * Execute the action.
     *
     * @param  int  $creditsDiff  En create credits = credits, en update credits = diferencia de credits en original y nuevo
     */
    public function handle(CreditTransaction $creditTransaction, int $creditsDiff): void
    {
        DB::transaction(function () use ($creditTransaction, $creditsDiff): void {
            $newerTransactions = CreditTransaction::query()
                ->where('enrollment_id', $creditTransaction->enrollment_id)
                ->where('transacted_at', '>=', $creditTransaction->transacted_at)
                ->where('id', '<>', $creditTransaction->id)
                ->orderBy('transacted_at')
                ->orderBy('id')
                ->get();

            if ($newerTransactions->count() === 0) {
                return;
            }

            foreach ($newerTransactions as $transaction) {
                $transaction->update([
                    'balance' => $transaction->balance + $creditsDiff,
                ]);
            }
        });
    }
}
