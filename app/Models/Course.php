<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CourseStatus;
use App\Enums\EnrollmentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'started_at',
        'status',
        'schedule',
        'teacher_id',
    ];

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
        return $this->hasMany(CoursePrice::class)->orderBy('started_at', 'desc');
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
     * Get the active enrollments for the course.
     *
     * @return HasMany<Enrollment, $this>
     */
    public function activeEnrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class)->where('status', EnrollmentStatus::ACTIVE);
    }

    /**
     * Get the lessons for the course.
     *
     * @return HasMany<Lesson, $this>
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('taught_at', 'desc');
    }

    /**
     * Get the latest price for the course.
     *
     * @return HasOne<CoursePrice, $this>
     */
    public function lastPrice(): HasOne
    {
        return $this->prices()->one()->ofMany([
            'started_at' => 'max',
            'id' => 'max',
        ]);
    }

    /**
     * Get the latest price for the course.
     *
     * @return HasOne<CoursePrice, $this>
     */
    public function nextPrice(string $started_at): HasOne
    {
        return $this->prices()->one()->ofMany([
            'started_at' => 'min',
            'id' => 'min',
        ], function (Builder $query) use ($started_at): void {
            $query->where('started_at', '>', $started_at);
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array{started_at: 'date', status: 'App\\Enums\\CourseStatus'}
     */
    protected function casts(): array
    {
        return [
            'started_at' => 'date',
            'status' => CourseStatus::class,
        ];
    }
}
