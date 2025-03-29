<?php

namespace Database\Seeders;

use App\Models\Product;
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

        // Seeding Product Manual
        $products = [
            [
                'name' => 'Klepon',
                'description' => 'Kue tradisional berbentuk bola dengan isian gula merah yang meleleh di dalam, dilapisi kelapa parut.',
                'image' => 'https://placehold.co/100',
                'price' => 5000,
            ],
            [
                'name' => 'Dadar Gulung',
                'description' => 'Kue dadar berwarna hijau dengan isian kelapa parut dan gula merah, lembut dan manis.',
                'image' => 'https://placehold.co/100',
                'price' => 7000,
            ],
            [
                'name' => 'Lemper',
                'description' => 'Ketan isi ayam atau abon yang dibungkus dengan daun pisang, gurih dan mengenyangkan.',
                'image' => 'https://placehold.co/100',
                'price' => 6000,
            ],
        ];


        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
