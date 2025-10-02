<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

final readonly class UpdateAttendance
{
    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $attendanceData
     */
    public function handle(Attendance $attendance, array $attendanceData): Attendance
    {
        return DB::transaction(function () use ($attendance, $attendanceData): Attendance {
            $attendance->fill([
                'status' => $attendanceData['status'],
                'notes' => $attendanceData['notes'] ?? null,
            ]);

            if ($attendance->isDirty()) {
                $attendance->save();
            }

            return $attendance;
        });
    }
}
