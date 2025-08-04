<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    /**
     * Get the teacher that owns the course.
     *
     * @return BelongsTo<Teacher, $this>
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get the prices for the course.
     *
     * @return HasMany<CoursePrice, $this>
     */
    public function prices(): HasMany
    {
        return $this->hasMany(CoursePrice::class);
    }

    /**
     * Get the enrollments for the course.
     *
     * @return HasMany<Enrollment, $this>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the lessons for the course.
     *
     * @return HasMany<Lesson, $this>
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'status' => CourseStatus::class,
        ];
    }
}
