<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Bang Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        User::factory()->create([
            'name' => 'Bang User',
            'email' => 'user@gmail.com',
            'role' => 'user',
            'password' => Hash::make('user123'),
        ]);

        // User::factory(10)->create();
    }
}
