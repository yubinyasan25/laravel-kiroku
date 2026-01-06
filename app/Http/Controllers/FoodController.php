<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    // ログイン必須（全アクション）
    public function __construct()
    {
        $this->middleware('auth');
    }

    // 一覧表示（本人の記録のみ）
    public function index()
    {
        $foods = Food::where('user_id', auth()->id())
                 ->orderBy('date', 'desc') // 日付の新しい順
                 ->get();
        
        // 月ごとにグループ化（YYYY-MM形式）
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

        // カテゴリを JSON に変換
        if(!empty($data['category'])) {
            $data['category'] = json_encode($data['category']);
        }

        // 写真アップロード
        $photo_paths = [];
        if($request->hasFile('photo')) {
            foreach($request->file('photo') as $photo){
                if($photo){
                    $photo_paths[] = $photo->store('photos','public');
                }
            }
        }
        $data['photo_paths'] = $photo_paths ? json_encode($photo_paths) : null;

        // ユーザー紐付け
        $data['user_id'] = Auth::id();

        Food::create($data);

        return redirect()->route('foods.index')->with('success','登録しました！');
    }

    // 編集フォーム
    public function edit(Food $food)
    {
        // 他ユーザーの編集を禁止
        if($food->user_id !== Auth::id()) abort(403);

        return view('foods.edit', compact('food'));
    }

    // 更新処理
    public function update(Request $request, Food $food)
    {
        // 他ユーザーの更新を禁止
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
            'photo_delete' => 'nullable|array',
            'date' => 'required|date',
        ]);

        $data = $request->only(['name','category','store_name','price','rating','comment','date']);

        // カテゴリを JSON に変換
        if(!empty($data['category'])) {
            $data['category'] = json_encode($data['category']);
        }

        // 既存写真取得
        $existing_photos = $food->photo_paths ? json_decode($food->photo_paths,true) : [];

        // 削除チェックされた写真を除外
        if($request->has('photo_delete')){
            $delete_indexes = $request->input('photo_delete');
            foreach($delete_indexes as $index){
                if(isset($existing_photos[$index])){
                    @unlink(storage_path('app/public/'.$existing_photos[$index]));
                    unset($existing_photos[$index]);
                }
            }
            // 再インデックス化
            $existing_photos = array_values($existing_photos);
        }

        // 新しい写真アップロード
        if($request->hasFile('photo')){
            foreach($request->file('photo') as $photo){
                if($photo){
                    $existing_photos[] = $photo->store('photos','public');
                }
            }
        }

        $data['photo_paths'] = !empty($existing_photos) ? json_encode($existing_photos) : null;

        $food->update($data);

        return redirect()->route('foods.index')->with('success','更新しました！');
    }

    // 削除処理
    public function destroy(Food $food)
    {
        if($food->user_id !== Auth::id()) abort(403);

        // 画像削除
        $photos = $food->photo_paths ? json_decode($food->photo_paths,true) : [];
        foreach($photos as $path){
            @unlink(storage_path('app/public/'.$path));
        }

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
