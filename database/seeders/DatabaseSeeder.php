<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);

        $electronics = Category::create([
            'name' => 'Электроника',
            'description' => 'Гаджеты и девайсы'
        ]);

        $clothing = Category::create([
            'name' => 'Одежда',
            'description' => 'Вещи для стиля'
        ]);

        Product::create([
            'category_id' => $electronics->id,
            'name' => 'iPhone 15',
            'description' => 'Крутой телефон',
            'price' => 999.99
        ]);

        Product::create([
            'category_id' => $electronics->id,
            'name' => 'MacBook Pro',
            'description' => 'Ноутбук для кодинга',
            'price' => 2500.00
        ]);

        Product::create([
            'category_id' => $clothing->id,
            'name' => 'Футболка',
            'description' => 'Спортивная футболка',
            'price' => 15.00
        ]);
    }
}
