<?php

declare(strict_types=1);

namespace App\Actions\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final readonly class CreateUser
{
    /**
     * Execute the action.
     *
     * @param  array<string, mixed>  $userData
     */
    public function handle(array $userData): User
    {
        return DB::transaction(fn () => User::create([
            'first_name' => $userData['first_name'],
            'last_name' => $userData['last_name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password'] ?? Str::password(12)),
            'status' => $userData['status'],
        ]));
    }
}
