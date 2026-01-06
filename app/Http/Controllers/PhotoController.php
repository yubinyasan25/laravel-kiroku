<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo; // 画像を保存するモデル

class PhotoController extends Controller
{
    // アップロードフォーム表示
    public function create()
    {
        $photos = Photo::latest()->get(); // 最新順で取得
        return view('photos.create', compact('photos'));
    }

    // アップロード処理
    public function upload(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048', // 2MBまで
        ]);

        // Cloudinary にアップロード
        $path = $request->file('photo')->store('', 'cloudinary');

        // Cloudinary の URL を取得
        $url = Storage::disk('cloudinary')->url($path);

        // DB に保存
        $photo = new Photo();
        $photo->url = $url;
        $photo->save();

        return redirect()->back()->with('success', '写真をアップロードしました！');
    }
}
