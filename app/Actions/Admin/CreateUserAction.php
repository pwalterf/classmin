<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final readonly class CreateUserAction
{
    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $userData
     */
    public function handle(array $userData, UserRole $role): void
    {
        DB::transaction(function () use ($userData, $role): void {
            $user = User::create([
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password'] ?? Str::password(12)),
            ]);

            $user->assignRole($role);
        });
    }
}
