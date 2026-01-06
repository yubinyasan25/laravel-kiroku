<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Cloudinary;

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

        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);

        $photo_paths = [];
        if($request->hasFile('photo')) {
            foreach($request->file('photo') as $photo){
                $uploaded = $cloudinary->uploadApi()->upload($photo->getRealPath());
                $photo_paths[] = [
                    'url' => $uploaded['secure_url'],
                    'public_id' => $uploaded['public_id']
                ];
            }
        }

        $data['photo_paths'] = !empty($photo_paths) ? json_encode($photo_paths) : null;
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

        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);

        // 削除チェックされた写真
        if($request->has('photo_delete')) {
            $delete_indexes = $request->input('photo_delete');
            foreach($delete_indexes as $index) {
                if(isset($existing_photos[$index])) {
                    $cloudinary->uploadApi()->destroy($existing_photos[$index]['public_id']);
                    unset($existing_photos[$index]);
                }
            }
            $existing_photos = array_values($existing_photos);
        }

        // 新しい写真アップロード
        if($request->hasFile('photo')) {
            foreach($request->file('photo') as $photo){
                $uploaded = $cloudinary->uploadApi()->upload($photo->getRealPath());
                $existing_photos[] = [
                    'url' => $uploaded['secure_url'],
                    'public_id' => $uploaded['public_id']
                ];
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

        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);

        foreach($photos as $photo){
            $cloudinary->uploadApi()->destroy($photo['public_id']);
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
