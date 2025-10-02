<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

final readonly class CreateAttendance
{
    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $attendanceData
     */
    public function handle(array $attendanceData, int $lessonID): Attendance
    {
        return DB::transaction(fn () => Attendance::create([
            'status' => $attendanceData['status'],
            'notes' => $attendanceData['notes'],
            'lesson_id' => $lessonID,
            'enrollment_id' => $attendanceData['enrollment']['id'],
        ]));
    }
}
