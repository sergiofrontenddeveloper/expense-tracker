<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Alimentación', 'color' => '#dc3545'],
            ['name' => 'Transporte', 'color' => '#0d6efd'],
            ['name' => 'Suscripciones', 'color' => '#6f42c1'],
            ['name' => 'Ocio', 'color' => '#fd7e14'],
            ['name' => 'Salud', 'color' => '#20c997'],
            ['name' => 'Otros', 'color' => '#6c757d'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        User::factory()->create([
            'name' => 'Usuario Demo',
            'email' => 'demo@example.com',
            'password' => 'password123',
        ]);
    }
}
