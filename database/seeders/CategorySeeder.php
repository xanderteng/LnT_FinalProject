<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['categoryName' => 'Electronics'],
            ['categoryName' => 'Clothing'],
            ['categoryName' => 'Furnitures'],
            ['categoryName' => 'Health Care'],
            ['categoryName' => 'Toys & Games'],
            ['categoryName' => 'Books, Movies & Music'],
            ['categoryName' => 'Sports'],
            ['categoryName' => 'Food & Grocery'],
            ['categoryName' => 'Travel & Luggage'],
            ['categoryName' => 'Pet Supplies']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
