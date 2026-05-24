<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Web Development', 'slug' => 'web-development'],
            ['name' => 'Mobile App', 'slug' => 'mobile-app'],
            ['name' => 'SEO', 'slug' => 'seo'],
            ['name' => 'Digital Marketing', 'slug' => 'digital-marketing'],
            ['name' => 'UI/UX Design', 'slug' => 'ui-ux-design'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }
    }
}
