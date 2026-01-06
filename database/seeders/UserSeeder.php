<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;                // Userモデルを読み込む
use Illuminate\Support\Facades\Hash; // パスワードハッシュ用

class UserSeeder extends Seeder
{
    public function run()
    {
        // テストアカウントを作成
        User::updateOrCreate(
            ['email' => 'test@example.com'], // メールが既にあれば更新
            [
                'name' => 'テスト太郎',
                'password' => Hash::make('password123'), // パスワード
                'email_verified_at' => now(), 
            ]
        );
    }
}
