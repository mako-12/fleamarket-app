{{-- {{ dd(session()->all()) }} --}}
@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/chatMessage.css') }}">
@endsection

@section('content')
    <div class="chat-page">
        <aside class="aside">
            <h2>その他の取引</h2>
            @foreach ($sidebarTransactions as $sidebarTransaction)
                <div class="other-items">
                    <a href="{{ route('chat.index', $sidebarTransaction->id) }}"
                        class="{{ $sidebarTransaction->id === $transaction->id ? 'active' : '' }} other-items__link">
                        {{ $sidebarTransaction->item->name }}
                    </a>
                </div>
            @endforeach
        </aside>

        <div class="chat-page__inner">
            <div class="chat-page__title">
                @if ($transaction->buyer_profile_id === auth()->user()->profile->id)
                    <div class="chat-page__image">
                        <img class="chat-page__icon"
                            src="{{ $transaction && $transaction->sellerProfile->profile_image ? asset('storage/' . $transaction->sellerProfile->profile_image) : asset('storage/profile_image/kkrn_icon_user_4.png') }}"
                            alt="プロフィール画像">
                    </div>
                    <div class="chat-page__user-name">
                        <h1>「{{ $transaction->sellerProfile->name }}」さんとの取引画面</h1>
                    </div>
                @elseif($transaction->seller_profile_id === auth()->user()->profile->id)
                    <div class="chat-page__image">
                        <img class="chat-page__icon"
                            src="{{ $transaction && $transaction->buyerProfile->profile_image ? asset('storage/' . $transaction->buyerProfile->profile_image) : asset('storage/profile_image/kkrn_icon_user_4.png') }}"
                            alt="プロフィール画像">
                    </div>
                    <div class="chat-page__user-name">
                        <h1>「{{ $transaction->buyerProfile->name }}」さんとの取引画面</h1>
                    </div>
                @endif

                @if ($transaction->buyer_profile_id === auth()->user()->profile->id)
                    {{-- <form action="{{ route('chat.index', ['transaction' => $transaction->id]) }}" method="GET">
                        @csrf
                        <div class="transaction-completed__button">
                            <input class="transaction-completed__button-input" type="submit" value="取引を完了する">
                        </div>
                    </form> --}}

                    <a href="{{ route('chat.modal', ['transaction' => $transaction->id]) }}"
                        class="transaction-completed__button">
                        取引を完了する
                    </a>
                @endif

            </div>

            <div class="chat-page__item">
                <div class="item-inner">
                    <img class="item-image" src="{{ asset('storage/' . $transaction->item->item_image) }}" alt="商品画像">

                    <div class="item-detail">
                        <h1 class="item-name">{{ $transaction->item->name }}</h1>
                        <p class="item-price">￥{{ $transaction->item->price }}</p>
                    </div>
                </div>
            </div>


            <form action="{{ route('chat.store', ['transaction' => $transaction->id]) }}" method="post">
                @csrf
                <div class="chat-page__main">
                    @foreach ($messages as $message)
                        <div class="chat-message {{ $message->sender_profile_id === $myProfileId ? 'me' : 'other' }}">
                            {{ $message->message }}
                        </div>
                    @endforeach
                </div>

                <div class="error-message">
                    @error('message')
                        {{ $message }}
                    @enderror
                </div>
                <div class="chat-page__form">
                    <input class="chat-page__text" type="text" name="message" placeholder="取引メッセージを記入してください"
                        value="{{ session('message') }}">
                    <div class="chat-image__area">
                        <label class="chat-image__label" for="fileupload">画像を追加</label>
                        <input class="chat-image__input" type="file" name="chat-image" id="fileupload">
                    </div>
                    <div class="button">
                        <label for="send-button">
                            <img class="send-icon" src="{{ asset('storage/icon_image/send_button.png') }}" alt="送信">
                        </label>
                        <input type="submit" id="send-button" hidden>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- モーダルウィンドウ --}}
    @if (session('showBuyerEvaluationModal'))
        <div class="modal-overlay">
            <form action="{{ route('evaluation.store', $transaction->id) }}" method="POST">
                @csrf
                <div class="modal-form__group" style="display:block;">

                    <p class="modal-title">取引が完了しました。</p>
                    <p class="modal-sub-title">今回の取引相手はどうでしたか？</p>

                    <div class="form-rating">
                        <input class="form-rating__input" id="star5" name="rating" type="radio" value="5">
                        <label class="form-rating__label" for="star5">★</label>

                        <input class="form-rating__input" id="star4" name="rating" type="radio" value="4">
                        <label class="form-rating__label" for="star4">★</label>

                        <input class="form-rating__input" id="star3" name="rating" type="radio" value="3"
                            checked>
                        <label class="form-rating__label" for="star3">★</label>

                        <input class="form-rating__input" id="star2" name="rating" type="radio" value="2">
                        <label class="form-rating__label" for="star2">★</label>

                        <input class="form-rating__input" id="star1" name="rating" type="radio" value="1">
                        <label class="form-rating__label" for="star1">★</label>

                    </div>
                    <div class="modal-submit">
                        <button class="modal-submit__button" type="submit">送信する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @if ($showSellerEvaluationModal)
        <div class="modal-overlay">
            <form action="{{ route('evaluation.store', $transaction->id) }}" method="POST">
                @csrf
                <div class="modal-form__group" style="display:block;">

                    <p class="modal-title">取引が完了しました。</p>
                    <p class="modal-sub-title">今回の取引相手はどうでしたか？</p>

                    <div class="form-rating">
                        <input class="form-rating__input" id="star5" name="rating" type="radio" value="5">
                        <label class="form-rating__label" for="star5">★</label>

                        <input class="form-rating__input" id="star4" name="rating" type="radio" value="4">
                        <label class="form-rating__label" for="star4">★</label>

                        <input class="form-rating__input" id="star3" name="rating" type="radio" value="3"
                            checked>
                        <label class="form-rating__label" for="star3">★</label>

                        <input class="form-rating__input" id="star2" name="rating" type="radio" value="2">
                        <label class="form-rating__label" for="star2">★</label>

                        <input class="form-rating__input" id="star1" name="rating" type="radio" value="1">
                        <label class="form-rating__label" for="star1">★</label>

                    </div>
                    <div class="modal-submit">
                        <button class="modal-submit__button" type="submit">送信する</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection
