<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['categoryName' => 'Software'],
            ['categoryName' => 'Hardware'],
            ['categoryName' => 'Accessories'],
            ['categoryName' => 'Services'],
            ['categoryName' => 'Subscriptions']
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
