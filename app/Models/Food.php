<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    // フォームから一括代入できるカラムを指定
    protected $table = 'foods'; 
    protected $fillable = [
        'name',
        'genre',
        'store_name',
        'price',
        'rating',
        'comment',
        'photo_path'
    ];
}
