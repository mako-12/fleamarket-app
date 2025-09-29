@extends('layouts.app', ['simpleHeader' => true])

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/verify.css') }}">
@endsection

@section('content')
    <div class="verify-page">
        <div class="verify-page__message">
            <p>登録していただいたメールアドレスに承認メールを送付しました。</p>
            <p>メール承認を完了してください。</p>
        </div>

        <div class="btn-submit">
            {{-- <a href="{{ route('verification.check') }}" class="btn-primary"> --}}
            <a href="http://localhost:8025/#" class="btn-primary">
                認証はこちら
            </a>
        </div>

        <form class="verity-submit" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-secondary">
                承認メールを再送する
            </button>
        </form>
    </div>
@endsection
