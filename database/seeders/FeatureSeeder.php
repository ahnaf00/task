<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $products = Product::factory(10)->create();
        }

        // Create 100 features and randomly associate them with the existing products
        Feature::factory(30)->make()->each(function ($feature) use ($products) {
            $feature->product_id = $products->random()->id;
            $feature->save();
        });
    }
}
