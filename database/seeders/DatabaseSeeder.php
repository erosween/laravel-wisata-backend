<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Database\Factories\CategoryFactory;
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
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'robby',
            'email' => 'robby@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        //categoru factory
        Category::factory(2)->create();


        //product factory 100
        Product::factory(100)->create();
    }
}
