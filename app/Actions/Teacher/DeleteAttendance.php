<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
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
                $this->deleteCreditTransaction->handle($attendance->creditTransaction);
            }

            $attendance->delete();
        });
    }
}
