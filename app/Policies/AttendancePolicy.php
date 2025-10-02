<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Models\Attendance;
use App\Models\User;

final class AttendancePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(UserPermission::VIEW_ATTENDANCES);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Attendance $attendance): bool
    {
        return $user->can(UserPermission::VIEW_ATTENDANCES)
            && ($user->teacher->id === $attendance->lesson->course->teacher->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(UserPermission::MANAGE_ATTENDANCES);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attendance $attendance): bool
    {
        return $user->can(UserPermission::MANAGE_ATTENDANCES)
            && ($user->teacher->id === $attendance->lesson->course->teacher->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attendance $attendance): bool
    {
        return $user->can(UserPermission::MANAGE_ATTENDANCES)
            && ($user->teacher->id === $attendance->lesson->course->teacher->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Attendance $attendance): bool
    {
        return $user->can(UserPermission::MANAGE_ATTENDANCES)
            && ($user->teacher->id === $attendance->lesson->course->teacher->id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attendance $attendance): bool
    {
        return $user->can(UserPermission::MANAGE_ATTENDANCES)
            && ($user->teacher->id === $attendance->lesson->course->teacher->id);
    }
}
