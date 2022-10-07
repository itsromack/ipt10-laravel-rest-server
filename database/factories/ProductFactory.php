<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categories = [
            'apparel',
            'health',
            'sports'
        ];
        $category = $categories[ array_rand($categories, 1) ];
        $image = '';
        return [
            'title' => fake()->word(),
            'price' => fake()->randomFloat(1, 200, 500),
            'brand' => fake()->word(),
            'category' => $category,
            'image' => fake()->imageUrl(
                640, // width
                480, // height
                'product'
            )
        ];
    }
}
