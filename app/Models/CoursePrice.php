<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class CoursePrice extends Model
{
    /** @use HasFactory<\Database\Factories\CoursePriceFactory> */
    use HasFactory;

    /**
     * Get the course that owns the price.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Course, $this>
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
