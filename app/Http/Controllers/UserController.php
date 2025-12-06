<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
     public function mypage()
     {
        $user = Auth::user();

        return view('users.mypage', compact('user'));
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user = Auth::user();

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user = Auth::user();

         // バリデーション
        $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'nickname' => ['nullable', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255'],
        ]);

       // 更新処理
        $user->name = $request->name;
        $user->nickname = $request->nickname;
        $user->email = $request->email;

        $user->save();

    return to_route('mypage')->with('flash_message', '会員情報を更新しました。');
    }

    public function update_password(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if ($request->input('password') == $request->input('password_confirmation')) {
            $user->password = bcrypt($request->input('password'));
            $user->update();
        } else {
            return to_route('mypage.edit_password');
        }

        return to_route('mypage')->with('flash_message', 'パスワードを更新しました。');
    }

    public function edit_password()
    {
        return view('users.edit_password');
    }

    public function favorite()
    {
        $user = Auth::user();

        $favorite_products = $user->favorite_products()->paginate(5);

        return view('users.favorite', compact('favorite_products'));
    }

    public function destroy(Request $request)
    {
        Auth::user()->delete();
        return redirect('/')->with('flash_message', '退会が完了しました。');
    }   
}
