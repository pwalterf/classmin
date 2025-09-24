<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\CoursePrice;
use Illuminate\Support\Facades\DB;

final readonly class DeleteCoursePrice
{
    /**
     * Execute the action.
     */
    public function handle(CoursePrice $coursePrice): void
    {
        DB::transaction(function () use ($coursePrice): void {
            $coursePrice->delete();
        });
    }
}
