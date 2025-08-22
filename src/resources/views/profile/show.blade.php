@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/show') }}">
@endsection

@section('content')
    <div class="profile-page">
        <div class="profile-page__inner">
            <div class="user-image">
                <img class="user-icon" src="{{ asset('storage/logo_image/' . $profile->profile_image) }}" alt="プロフィール画像">
            </div>
            <div class="user-name">
                <p></p>
            </div>
        </div>


    </div>
@endsection
