<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;

final readonly class DeletePayment
{
    /**
     * Execute the action.
     */
    public function handle(Payment $payment): void
    {
        DB::transaction(function () use ($payment): void {
            $payment->delete();
        });
    }
}
