<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            // 料理
            ['name' => '和食', 'major_category_id' => 1, 'description' => '日本の伝統的な料理'],
            ['name' => '洋食', 'major_category_id' => 1, 'description' => '西洋風の料理'],
            ['name' => '中華', 'major_category_id' => 1, 'description' => '中国の料理'],
            ['name' => '韓国料理', 'major_category_id' => 1, 'description' => '韓国の料理'],
            ['name' => '家庭料理', 'major_category_id' => 1, 'description' => '家庭で作る料理'],

            // スイーツ
            ['name' => 'ケーキ', 'major_category_id' => 2, 'description' => '焼き菓子'],
            ['name' => 'クッキー', 'major_category_id' => 2, 'description' => 'サクサクしたお菓子'],
            ['name' => '和菓子', 'major_category_id' => 2, 'description' => '日本の伝統的なお菓子'],
            ['name' => 'プリン', 'major_category_id' => 2, 'description' => '滑らかなスイーツ'],
            ['name' => 'その他スイーツ', 'major_category_id' => 2, 'description' => 'その他のスイーツ'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
