<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Laravel\Facades\Cloudinary;

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
        if(!empty($data['category'])) {
            $data['category'] = json_encode($data['category']);
        }

        // Cloudinary にアップロード
        $photo_paths = [];
        if($request->hasFile('photo')) {
            foreach($request->file('photo') as $photo){
                if($photo){
                    $uploaded = Cloudinary::upload($photo->getRealPath());
                    $photo_paths[] = [
                        'url' => $uploaded->getSecurePath(),
                        'public_id' => $uploaded->getPublicId()
                    ];
                }
            }
        }

        $data['photo_paths'] = $photo_paths ? json_encode($photo_paths) : null;
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
            'photo_delete' => 'nullable|array',
            'date' => 'required|date',
        ]);

        $data = $request->only(['name','category','store_name','price','rating','comment','date']);
        if(!empty($data['category'])) {
            $data['category'] = json_encode($data['category']);
        }

        $existing_photos = $food->photo_paths ? json_decode($food->photo_paths, true) : [];

        // 削除チェックされた写真を Cloudinary から削除
        if($request->has('photo_delete')) {
            $delete_indexes = $request->input('photo_delete');
            foreach($delete_indexes as $index) {
                if(isset($existing_photos[$index])) {
                    Cloudinary::destroy($existing_photos[$index]['public_id']);
                    unset($existing_photos[$index]);
                }
            }
            $existing_photos = array_values($existing_photos);
        }

        // 新しい写真アップロード
        if($request->hasFile('photo')) {
            foreach($request->file('photo') as $photo){
                if($photo){
                    $uploaded = Cloudinary::upload($photo->getRealPath());
                    $existing_photos[] = [
                        'url' => $uploaded->getSecurePath(),
                        'public_id' => $uploaded->getPublicId()
                    ];
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

        $photos = $food->photo_paths ? json_decode($food->photo_paths,true) : [];
        foreach($photos as $photo){
            Cloudinary::destroy($photo['public_id']);
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
