<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Product::factory(10)->create();
        $users = User::all();

        if ($users->isEmpty()) {
            $users = User::factory(5)->create();
        }

        // Create 50 products and randomly associate them with the existing users
        Product::factory(20)->make()->each(function ($product) use ($users) {
            $product->user_id = $users->random()->id;
            $product->save();
        });
    }
}
