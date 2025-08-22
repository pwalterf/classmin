<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class ChangeUserStatus
{
    /**
     * Execute the action.
     */
    public function handle(User $user, string $status): User
    {
        return DB::transaction(function () use ($user, $status): User {
            if ($user->status !== $status) {
                $user->status = $status;
            }

            return $user;
        });
    }
}
