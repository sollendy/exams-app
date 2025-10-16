<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);

        User::factory()->supervisor()->create([
            'name' => 'Supervisor User',
            'email' => 'supervisor@example.com',
            'password' => bcrypt('supervisor123'),
        ]);

        // User::factory()->user()->create([
        //     'name' => 'Regular User',
        //     'email' => 'user@example.com',
        //     'password' => bcrypt('user123'),
        // ]);
       User::factory()->user()->count(10)->create();

    }
}
