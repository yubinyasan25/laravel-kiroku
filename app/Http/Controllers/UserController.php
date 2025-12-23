<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();
        return view('users.mypage', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user->update([
            'name' => $request->name,
            'nickname' => $request->nickname,
            'email' => $request->email,
        ]);

        return to_route('mypage')->with('flash_message', '会員情報を更新しました。');
    }

    public function edit_password()
    {
        return view('users.edit_password');
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return to_route('mypage')->with('flash_message', 'パスワードを更新しました。');
    }

    public function favorite()
    {
        $user = Auth::user();
        $favorite_products = $user->favorite_products()->paginate(5);

        return view('users.favorite', compact('favorite_products'));
    }

    public function destroy()
    {
        $user = Auth::user();
        $user->delete(); // SoftDeletesで退会扱い
        Auth::logout();

        return redirect('/')->with('flash_message', '退会が完了しました。');
    }
}
