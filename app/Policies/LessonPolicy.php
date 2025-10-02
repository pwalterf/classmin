<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Models\Lesson;
use App\Models\User;

final class LessonPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(UserPermission::VIEW_LESSONS);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Lesson $lesson): bool
    {
        return $user->can(UserPermission::VIEW_LESSONS)
            && ($user->teacher->id === $lesson->course->teacher->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(UserPermission::MANAGE_LESSONS);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lesson $lesson): bool
    {
        return $user->can(UserPermission::MANAGE_LESSONS)
            && ($user->teacher->id === $lesson->course->teacher->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lesson $lesson): bool
    {
        return $user->can(UserPermission::MANAGE_LESSONS)
            && ($user->teacher->id === $lesson->course->teacher->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lesson $lesson): bool
    {
        return $user->can(UserPermission::MANAGE_LESSONS)
            && ($user->teacher->id === $lesson->course->teacher->id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lesson $lesson): bool
    {
        return $user->can(UserPermission::MANAGE_LESSONS)
            && ($user->teacher->id === $lesson->course->teacher->id);
    }
}
