<?php

declare(strict_types=1);

namespace App\Http\Resources\Teacher;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Student $student
 * @property-read Course $course
 * @property-read float $payments_sum_amount
 * @property-read float $payments_sum_credits_purchased
 */
final class ARCAReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'student' => $this->student->full_name,
            'course' => $this->course->title,
            'total_amount' => $this->payments_sum_amount,
            'total_credits_purchased' => $this->payments_sum_credits_purchased,
        ];
    }
}
