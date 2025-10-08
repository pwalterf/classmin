<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserPermission;
use App\Models\CreditTransaction;
use App\Models\User;

final class CreditTransactionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can(UserPermission::VIEW_CREDIT_TRANSACTIONS);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CreditTransaction $creditTransaction): bool
    {
        return $user->can(UserPermission::VIEW_CREDIT_TRANSACTIONS)
            && ($user->teacher->id === $creditTransaction->enrollment->course->teacher->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can(UserPermission::MANAGE_CREDIT_TRANSACTIONS);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CreditTransaction $creditTransaction): bool
    {
        return $user->can(UserPermission::MANAGE_CREDIT_TRANSACTIONS)
            && ($user->teacher->id === $creditTransaction->enrollment->course->teacher->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CreditTransaction $creditTransaction): bool
    {
        return $user->can(UserPermission::MANAGE_CREDIT_TRANSACTIONS)
            && ($user->teacher->id === $creditTransaction->enrollment->course->teacher->id);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CreditTransaction $creditTransaction): bool
    {
        return $user->can(UserPermission::MANAGE_CREDIT_TRANSACTIONS)
            && ($user->teacher->id === $creditTransaction->enrollment->course->teacher->id);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CreditTransaction $creditTransaction): bool
    {
        return $user->can(UserPermission::MANAGE_CREDIT_TRANSACTIONS)
            && ($user->teacher->id === $creditTransaction->enrollment->course->teacher->id);
    }
}
