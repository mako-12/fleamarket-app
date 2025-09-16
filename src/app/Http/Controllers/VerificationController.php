<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    public function check(Request $request)
    {
        if (!$request->user()) {
            return redirect()->route('login')->with('status', 'ログインしてください');
        }

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('profile.create')->with('status', 'メール認証済みです！');
        }

        return redirect()->route('verification.notice')->with('status', 'まだ認証が完了していません');
    }

    public function verify(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('profile.create')->with('status', 'すでに認証済みです');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->route('profile.create')->with('status', 'メール認証が完了しました！');
    }
}
