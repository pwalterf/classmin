<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Enums\AttendanceStatus;
use App\Enums\CreditTransactionType;
use App\Models\Attendance;
use App\Models\CreditTransaction;
use Illuminate\Support\Facades\DB;

final readonly class CreateAttendance
{
    /**
     * CreateAttendance constructor.
     */
    public function __construct(
        private CreateCreditTransaction $createCreditTransaction,
    ) {}

    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $attendanceData
     */
    public function handle(array $attendanceData, int $lessonID): Attendance
    {
        return DB::transaction(function () use ($attendanceData, $lessonID) {
            $attendance = Attendance::create([
                'status' => $attendanceData['status'],
                'notes' => $attendanceData['notes'],
                'lesson_id' => $lessonID,
                'enrollment_id' => $attendanceData['enrollment']['id'],
            ]);

            if ($attendance->status !== AttendanceStatus::EXCUSED) {
                $creditTransaction = new CreditTransaction([
                    'transacted_at' => $attendance->lesson->taught_at,
                    'type' => CreditTransactionType::USE,
                    'credits' => -1,
                    'description' => 'Attendance ID: '.$attendance->id,
                    'enrollment_id' => $attendance->enrollment_id,
                    'transactable_type' => Attendance::class,
                    'transactable_id' => $attendance->id,
                ]);

                $this->createCreditTransaction->handle($creditTransaction);
            }

            return $attendance;
        });
    }
}
