<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Mushuklar', 'slug' => 'mushuklar'],
            ['name' => 'Itlar', 'slug' => 'itlar'],
            ['name' => 'Qushlar', 'slug' => 'qushlar'],
            ['name' => 'Baliqlar', 'slug' => 'baliqlar'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
