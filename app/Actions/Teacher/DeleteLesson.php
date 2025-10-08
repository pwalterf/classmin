<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Lesson;
use Illuminate\Support\Facades\DB;

final readonly class DeleteLesson
{
    /**
     * DeleteLesson constructor.
     */
    public function __construct(
        private DeleteAttendance $deleteAttendance,
    ) {}

    /**
     * Execute the action.
     */
    public function handle(Lesson $lesson): void
    {
        DB::transaction(function () use ($lesson): void {
            foreach ($lesson->attendances as $attendance) {
                $this->deleteAttendance->handle($attendance);
            }

            $lesson->delete();
        });
    }
}
