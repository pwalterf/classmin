<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Lesson;
use Illuminate\Support\Facades\DB;

final readonly class DeleteLesson
{
    /**
     * Execute the action.
     */
    public function handle(Lesson $lesson): void
    {
        DB::transaction(function () use ($lesson): void {
            $lesson->delete();
        });
    }
}
