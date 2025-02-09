<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categoryId = Category::inRandomOrder()->first()->id;

        return [
            'category_id' => $categoryId,
            'itemName' => $this->faker->words(mt_rand(1, 10), true),  
            'itemPrice' => $this->faker->numberBetween(2, 20000) * 500, // 1k-10m
            'itemQuantity' => $this->faker->numberBetween(0, 10),
            'itemPicture' => $this->faker->imageUrl(640, 480, 'products', true)
        ];
    }
}
