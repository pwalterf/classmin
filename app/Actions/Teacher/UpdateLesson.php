<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Attendance;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;

final readonly class UpdateLesson
{
    /**
     * CreateLesson constructor.
     */
    public function __construct(
        private UpdateAttendance $updateAttendance,
    ) {}

    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $lessonData
     */
    public function handle(Lesson $lesson, array $lessonData): Lesson
    {
        return DB::transaction(function () use ($lesson, $lessonData): Lesson {
            $lesson->fill([
                'taught_at' => $lessonData['taught_at'],
                'notes' => $lessonData['notes'] ?? null,
                'student_page' => $lessonData['student_page'],
                'workbook_page' => $lessonData['workbook_page'],
            ]);

            if ($lesson->isDirty()) {
                $lesson->save();
            }

            foreach ($lessonData['attendances'] as $attendance) {
                $this->updateAttendance->handle(Attendance::find($attendance['id']), $attendance);
            }

            return $lesson;
        });
    }
}
