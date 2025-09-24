<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Models\CoursePrice;
use App\Models\User;

final class CoursePricePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(UserPermission::VIEW_COURSE_PRICES);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CoursePrice $coursePrice): bool
    {
        return $user->can(UserPermission::VIEW_COURSE_PRICES)
            && ($user->teacher->id === $coursePrice->course->teacher->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(UserPermission::VIEW_COURSE_PRICES);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CoursePrice $coursePrice): bool
    {
        return $user->can(UserPermission::VIEW_COURSE_PRICES)
            && ($user->teacher->id === $coursePrice->course->teacher->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CoursePrice $coursePrice): bool
    {
        return $user->can(UserPermission::VIEW_COURSE_PRICES)
            && ($user->teacher->id === $coursePrice->course->teacher->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CoursePrice $coursePrice): bool
    {
        return $user->can(UserPermission::VIEW_COURSE_PRICES)
            && ($user->teacher->id === $coursePrice->course->teacher->id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CoursePrice $coursePrice): bool
    {
        return $user->can(UserPermission::VIEW_COURSE_PRICES)
            && ($user->teacher->id === $coursePrice->course->teacher->id);
    }
}
