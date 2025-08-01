<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $teacherUser = User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
        ]);

        $adminUser->assignRole('admin');
        $teacherUser->assignRole('teacher');
    }
}
