<?php

declare(strict_types=1);

namespace App\Actions\Teacher;

use App\Models\CoursePrice;
use Illuminate\Support\Facades\DB;

final readonly class UpdateCoursePrice
{
    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $coursePriceData
     */
    public function handle(array $coursePriceData, CoursePrice $coursePrice): CoursePrice
    {
        return DB::transaction(function () use ($coursePriceData, $coursePrice): CoursePrice {
            $coursePrice->fill($coursePriceData);

            if ($coursePrice->isDirty()) {
                $coursePrice->save();
            }

            return $coursePrice;
        });
    }
}
