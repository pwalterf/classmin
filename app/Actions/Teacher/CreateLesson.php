<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Lesson;
use Illuminate\Support\Facades\DB;

final readonly class CreateLesson
{
    /**
     * CreateLesson constructor.
     */
    public function __construct(
        private CreateAttendance $createAttendance,
    ) {}

    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $lessonData
     */
    public function handle(array $lessonData): Lesson
    {
        return DB::transaction(function () use ($lessonData) {
            $lesson = Lesson::create([
                'notes' => $lessonData['notes'],
                'taught_at' => $lessonData['taught_at'],
                'student_page' => $lessonData['student_page'] ?? null,
                'workbook_page' => $lessonData['workbook_page'] ?? null,
                'course_id' => $lessonData['course_id'],
            ]);

            foreach ($lessonData['attendances'] as $attendance) {
                $this->createAttendance->handle($attendance, $lesson->id);
            }

            return $lesson;
        });
    }
}
