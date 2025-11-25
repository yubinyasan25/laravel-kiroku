<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MajorCategory;

class MajorCategoriesSeeder extends Seeder
{
    public function run()
    {
        $major_categories = [
            [
                'name' => '料理',
                'description' => '調理レシピや普段のごはんの記録'
            ],
            [
                'name' => 'スイーツ',
                'description' => '甘いものの記録やレビュー'
            ],
        ];

        foreach ($major_categories as $major_category) {
            MajorCategory::create($major_category);
        }
    }
}
