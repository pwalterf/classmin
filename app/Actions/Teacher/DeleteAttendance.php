<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Enums\AttendanceStatus;
use App\Enums\CreditTransactionType;
use App\Models\Attendance;
use App\Models\CreditTransaction;
use Illuminate\Support\Facades\DB;

final readonly class DeleteAttendance
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
    public function handle(Attendance $attendance): void
    {
        DB::transaction(function () use ($attendance): void {
            if ($attendance->status !== AttendanceStatus::EXCUSED) {
                $creditTransaction = new CreditTransaction([
                    'enrollment_id' => $attendance->enrollment_id,
                    'transacted_at' => $attendance->lesson->taught_at,
                    'type' => CreditTransactionType::USE,
                ]);

                $this->deleteCreditTransaction->handle($creditTransaction);
            }

            $attendance->delete();
        });
    }
}
