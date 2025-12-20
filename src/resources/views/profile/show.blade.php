@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile/show.css') }}">
@endsection

@section('content')
    <div class="profile-page">
        <div class="profile-page__information">
            <div class="user-image">
                <img class="user-icon"
                    src="{{ $profile && $profile->profile_image ? asset('storage/' . $profile->profile_image) : asset('storage/profile_image/kkrn_icon_user_4.png') }}"
                    alt="プロフィール画像">
            </div>

            <div class="name-area">
                <div class="user-name">
                    <h2>{{ $profile->name }}</h2>
                </div>

                @if ($roundedRating)
                    <div class="form-rating is-display">
                        @for ($i = 5; $i >= 1; $i--)
                            <span class="star {{ $i <= $roundedRating ? 'is-active' : '' }}">
                                ★
                            </span>
                        @endfor
                    </div>
                @endif
            </div>



            <p class="profile-page__edit">
                <a href="{{ route('profile.setup') }}" class="profile-edit-link">プロフィールを編集</a>
            </p>
        </div>






        <div class="profile-page__item-list">
            <input type="radio" name="tab-btn" id="tab-sell"{{ $tab === 'sell' ? 'checked' : '' }}>
            <input type="radio" name="tab-btn" id="tab-purchase"{{ $tab === 'buy' ? 'checked' : '' }}>
            <input type="radio" name="tab-btn" id="tab-trading"{{ $tab === 'trading' ? 'checked' : '' }}>

            <div class="tab-name">
                <label class="tab-label" for="tab-sell"
                    onclick="window.location='{{ route('mypage', ['tab' => 'sell']) }}'">出品した商品</label>
                <label class="tab-label" for="tab-purchase"
                    onclick="window.location='{{ route('mypage', ['tab' => 'buy']) }}'">購入した商品</label>
                <label class="tab-label" for="tab-trading"
                    onclick="window.location='{{ route('mypage', ['tab' => 'trading']) }}">取引中の商品
                    @if ($unreadMessageCount > 0)
                        <span class="badge">
                            {{ $unreadMessageCount }}
                        </span>
                    @endif
                </label>
            </div>
            {{-- 出品した商品 --}}
            <div class="tab-page">
                <div class="tab-panel" id="sell-panel">
                    <div class="tab-panel__inner">
                        <div class="sell-panel">
                            @forelse ($items as $item)
                                <div class="item-card">
                                    <a href="/item/{{ $item->id }}"><img
                                            src="{{ asset('storage/' . $item->item_image) }}" alt="商品画像">
                                    </a>
                                    <p class="my-item-name">{{ $item->name }}</p>
                                </div>
                            @empty
                                <p class="sell-panel__message">まだ商品を出品していません</p>
                            @endforelse

                        </div>
                    </div>
                </div>
                {{-- 購入済みタグ --}}
                <div class="tab-panel" id="purchase-panel">
                    <div class="purchase-panel">
                        {{-- @forelse($purchases as $purchase)
                            <div class="item-card">
                                <a href="/item/{{ $purchase->item->id }}"><img
                                        src="{{ asset('storage/' . $purchase->item->item_image) }}" alt="商品画像">
                                </a>
                                <p class="my-item-name">{{ $purchase->item->name }}</p>
                            </div> --}}

                        @forelse($evaluatedTransactions as $evaluatedTransaction)
                            @if ($evaluatedTransaction->status === \App\Models\Transaction::EVALUATED_COMPLETE)
                                <div class="item-card">
                                    <a href="/item/{{ $evaluatedTransaction->item->id }}"><img
                                            src="{{ asset('storage/' . $evaluatedTransaction->item->item_image) }}"
                                            alt="商品画像">
                                    </a>
                                    <p class="my-item-name">{{ $evaluatedTransaction->item->name }}</p>
                                </div>
                            @endif
                        @empty
                            <p class="sell-panel__message">まだ商品を購入していません</p>
                        @endforelse
                    </div>
                </div>

                {{-- 取引中の商品タグ --}}
                <div class="tab-panel" id="trading-panel">
                    <div class="trading-panel">
                        @php
                            $transactions = $tradingTransactions->merge($completedTransactions);
                        @endphp


                        @forelse($tradingTransactions as $transaction)
                            <div class="item-card">

                                <a href="/transactions/{{ $transaction->id }}/chat">
                                    <img src="{{ asset('storage/' . $transaction->item->item_image) }}" alt="商品画像">
                                </a>

                                @if ($unreadMessagesByTransaction->has($transaction->id))
                                    <span class="badge-item">
                                        {{ $unreadMessagesByTransaction[$transaction->id] }}
                                    </span>
                                @endif

                                <p class="my-item-name">{{ $transaction->item->name }}
                                </p>
                            </div>
                        @empty
                            <p class="sell-panel__message">取引中の商品はありません</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
