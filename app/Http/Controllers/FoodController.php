<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    // 一覧表示
    public function index()
    {
        $foods = Food::latest()->get(); // 新しい順
        return view('foods.index', compact('foods'));
    }

    // 登録フォーム
    public function create()
    {
        return view('foods.create');
    }

    // 登録処理
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'nullable|array',
        'category.*' => 'string|max:255',
        'store_name' => 'nullable|string|max:255',
        'price' => 'nullable|string|max:255',
        'rating' => 'nullable|integer|min:1|max:5',
        'comment' => 'nullable|string',
        'photo.*' => 'nullable|image|max:2048',
        'date' => 'required|date',
    ]);

    $data = $request->only(['name', 'category', 'store_name', 'price', 'rating', 'comment', 'date']);

    // カテゴリを JSON に変換して保存
    if(!empty($data['category'])) {
        $data['category'] = json_encode($data['category']);
    }

    // 写真アップロード（複数対応）
    if ($request->hasFile('photo')) {
        $photo_paths = [];
        foreach ($request->file('photo') as $photo) {
            if ($photo) {
                $path = $photo->store('photos', 'public');
                $photo_paths[] = $path;
            }
        }
        $data['photo_paths'] = json_encode($photo_paths);
    }

    Food::create($data);

    return redirect()->route('foods.index')->with('success', '登録しました！');
}

// 更新処理
public function update(Request $request, Food $food)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'nullable|array',
        'category.*' => 'string|max:255',
        'store_name' => 'nullable|string|max:255',
        'price' => 'nullable|string|max:255',
        'rating' => 'nullable|integer|min:1|max:5',
        'comment' => 'nullable|string',
        'photo.*' => 'nullable|image|max:2048',
        'date' => 'required|date',
    ]);

    $data = $request->only(['name', 'category', 'store_name', 'price', 'rating', 'comment', 'date']);

    // カテゴリを JSON に変換
    if(!empty($data['category'])) {
        $data['category'] = json_encode($data['category']);
    }

    // 写真アップロード（既存も残す場合はマージ可能）
    if ($request->hasFile('photo')) {
        $photo_paths = [];
        foreach ($request->file('photo') as $photo) {
            if ($photo) {
                $path = $photo->store('photos', 'public');
                $photo_paths[] = $path;
            }
        }
        $data['photo_paths'] = json_encode($photo_paths);
    }

    $food->update($data);

    return redirect()->route('foods.index')->with('success', '更新しました！');
}
}