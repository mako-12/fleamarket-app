<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        // ユーザー取得（例：セッションやリクエストから）
        $user = User::where('email', $request->email)->first();

        Auth::login($user);

        event(new Registered($user));


        return redirect()->route('verification.notice');
    }
}
