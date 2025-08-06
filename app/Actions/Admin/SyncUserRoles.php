<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class SyncUserRoles
{
    /**
     * Execute the action.
     *
     * @param  array<int, string>  $roles
     */
    public function handle(User $user, array $roles): void
    {
        DB::transaction(function () use ($user, $roles): void {
            if (! $user->hasExactRoles($roles)) {
                $user->syncRoles($roles);
            }
        });
    }
}
