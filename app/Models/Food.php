<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    // ← これを明示的に指定（安心）
    protected $table = 'foods';

    protected $fillable = [
        'user_id',
        'name',
        'date',
        'category',
        'store_name',
        'price',
        'rating',
        'comment',
        'photo_paths',
       
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
