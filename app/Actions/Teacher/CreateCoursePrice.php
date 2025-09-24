<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\Course;
use App\Models\CoursePrice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

final readonly class CreateCoursePrice
{
    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $coursePriceData
     */
    public function handle(array $coursePriceData, Course $course): CoursePrice
    {
        return DB::transaction(function () use ($coursePriceData, $course) {
            $lastPrice = $course->lastPrice()->first();

            if ($lastPrice) {
                $lastPrice->update([
                    'ended_at' => new Carbon($coursePriceData['started_at'])->subDay(),
                ]);
            }

            return CoursePrice::create([
                'price' => $coursePriceData['price'],
                'currency' => $coursePriceData['currency'],
                'started_at' => $coursePriceData['started_at'],
                'ended_at' => $coursePriceData['ended_at'] ?? null,
                'course_id' => $course->id,
            ]);
        });
    }
}
