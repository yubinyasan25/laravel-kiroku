<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    // ログイン必須
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 一覧表示
    public function index()
    {
        $foods = Food::where('user_id', auth()->id())
                 ->orderBy('date', 'desc')
                 ->get();

        $foodsByMonth = $foods->groupBy(function($item) {
            return \Carbon\Carbon::parse($item->date)->format('Y-m');
        });

        return view('foods.index', compact('foodsByMonth'));
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

        $data = $request->only(['name','category','store_name','price','rating','comment','date']);
        if(!empty($data['category'])) {
            $data['category'] = json_encode($data['category']);
        }

        // 画像を BLOB として保存（1枚目のみ）
        if($request->hasFile('photo')) {
            $file = $request->file('photo')[0];
            $data['photo_blob'] = file_get_contents($file->getRealPath());
        }

        $data['user_id'] = Auth::id();

        Food::create($data);

        return redirect()->route('foods.index')->with('success','登録しました！');
    }

    // 編集フォーム
    public function edit(Food $food)
    {
        if($food->user_id !== Auth::id()) abort(403);
        return view('foods.edit', compact('food'));
    }

    // 更新処理
    public function update(Request $request, Food $food)
    {
        if($food->user_id !== Auth::id()) abort(403);

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

        $data = $request->only(['name','category','store_name','price','rating','comment','date']);
        if(!empty($data['category'])) {
            $data['category'] = json_encode($data['category']);
        }

        // 画像を更新（1枚目のみ）
        if($request->hasFile('photo')) {
            $file = $request->file('photo')[0];
            $data['photo_blob'] = file_get_contents($file->getRealPath());
        }

        $food->update($data);

        return redirect()->route('foods.index')->with('success','更新しました！');
    }

    // 削除処理
    public function destroy(Food $food)
    {
        if($food->user_id !== Auth::id()) abort(403);

        $food->delete();

        return redirect()->route('foods.index')->with('success','削除しました！');
    }

    // 詳細表示
    public function show(Food $food)
    {
        if($food->user_id !== Auth::id()) abort(403);
        return view('foods.show', compact('food'));
    }
}
