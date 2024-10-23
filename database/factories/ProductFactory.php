<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'     => $this->faker->words(3, true),
            'category'  => $this->faker->randomElement(['electronics', 'furniture', 'clothing', 'beauty', 'sports']),
            'user_id'   => User::factory(),
            'image'     => $this->faker->imageUrl(640, 480, 'products', true)
        ];
    }
}
