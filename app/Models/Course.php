<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    /**
     * Get the prices for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<CoursePrice, $this>
     */
    public function prices()
    {
        return $this->hasMany(CoursePrice::class);
    }
}
