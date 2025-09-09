@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/show.css') }}">
@endsection

@section('content')
    <div class="profile-page">
        <div class="profile-page__inner">
            <div class="profile-page__information">
                <div class="user-image">
                    <img class="user-icon"
                        src="{{ $profile && $profile->profile_image ? asset('storage/' . $profile->profile_image) : asset('storage/profile_image/kkrn_icon_user_4.png') }}"
                        alt="プロフィール画像">
                </div>
                <div class="user-name">
                    <h2>{{ $profile->name }}</h2>
                </div>

                {{-- <form class="profile-page__edit" action="{{ route('profile.setup') }}" method="GET">
                    <div class="profile-page__edit-inner">
                        <input type="submit" value="プロフィールを編集">
                    </div>
                </form> --}}
                <p class="profile-page__edit">
                    <a href="{{ route('profile.setup') }}" class="btn profile-edit-link">プロフィールを編集</a>
                </p>
            </div>


            <div class="profile-page__item-list">
                <input type="radio" name="tab-btn" id="tab-sell" checked>
                <input type="radio" name="tab-btn" id="tab-purchase">

                <div class="tab-name">
                    <label class="tab-label" for="tab-sell">出品した商品</label>
                    <label class="tab-label" for="tab-purchase">購入した商品</label>
                </div>

                <div class="tab-page">
                    <div class="tab-panel" id="sell-panel">
                        <div class="tab-panel__inner">
                            <div class="sell-panel" id="sell-panel">
                                {{-- @foreach ($items as $item)
                                    <a href="/item/{{ $item->id }}"><img
                                            src="{{ asset('storage/' . $item->item_image) }}" alt="商品画像">
                                        <p clas="my-item-name">{{ $item->name }}</p>
                                @endforeach --}}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="tab-page">
                    <div class="tab-panel" id="purchase-panel">
                        <div class="tab-panel__inner">
                            <div class="purchase-panel">
                                <p>2page</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>


    </div>
@endsection
