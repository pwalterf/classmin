<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Teacher;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
        ]);

        // User::factory(10)->create();

        $adminUser = User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admintest'), // Ensure a password is set
        ]);

        $teacherUser = User::create([
            'first_name' => 'Teacher',
            'last_name' => 'User',
            'email' => 'teacher@example.com',
            'password' => Hash::make('teachertest'), // Ensure a password is set
            'status' => UserStatus::ACTIVE,
        ]);

        Teacher::create([
            'bio' => 'bla bla',
            'user_id' => $teacherUser->id,
        ]);

        Teacher::factory()
            ->count(15)
            ->sequence(fn (): array => ['user_id' => User::factory()->create()])
            ->create();

        $adminUser->assignRole(UserRole::ADMIN);
        $teacherUser->assignRole(UserRole::TEACHER);
    }
}
