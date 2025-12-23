<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * 登録フォームを表示
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * 新規登録処理
     */
    public function store(Request $request): RedirectResponse
    {
        // バリデーション
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // 退会済みも含めて既存ユーザーを検索
        $user = User::withTrashed()->where('email', $request->email)->first();

        if ($user) {
            // 退会済みなら復活
            if ($user->trashed()) {
                $user->restore();
            }
            // 名前とパスワードを更新
            $user->name = $request->name;
            $user->password = Hash::make($request->password);
            $user->save();
        } else {
            // 新規作成
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        }

        // 登録イベントを発火（メール通知など）
        event(new Registered($user));

        // ログイン
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
