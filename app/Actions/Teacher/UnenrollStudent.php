<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

final readonly class UnenrollStudent
{
    /**
     * UnenrollStudent constructor.
     */
    public function __construct(
        private DeleteAttendance $deleteAttendance,
        private DeletePayment $deletePayment,
        private DeleteCreditTransaction $deleteCreditTransaction,
    ) {}

    /**
     * Execute the action.
     */
    public function handle(Enrollment $enrollment): void
    {
        DB::transaction(function () use ($enrollment): void {
            foreach ($enrollment->attendances as $attendance) {
                $this->deleteAttendance->handle($attendance);
            }
            foreach ($enrollment->payments as $payment) {
                $this->deletePayment->handle($payment);
            }
            foreach ($enrollment->creditTransactions as $creditTransaction) {
                $this->deleteCreditTransaction->handle($creditTransaction);
            }
            $enrollment->delete();
        });
    }
}
