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

                    <div class="transaction-completed__button">
                        <a href="{{ route('chat.modal', ['transaction' => $transaction->id]) }}">
                            取引を完了する
                        </a>
                    </div>
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

            {{-- チャット欄 --}}
            <form action="{{ route('chat.store', ['transaction' => $transaction->id]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @foreach ($messages as $message)
                    @php
                        $isMine = $message->sender_profile_id === auth()->user()->profile->id;
                    @endphp
                    <div class="chat-message {{ $isMine ? 'is-mine' : 'is-other' }}">
                        <div class="chat-user">
                            <img class="chat-page__main-icon"
                                src="{{ $message->senderProfile->profile_image
                                    ? asset('storage/' . $message->senderProfile->profile_image)
                                    : asset('storage/profile_image/kkrn_icon_user_4.png') }}"
                                alt="プロフィール画像">
                            <p class="chat-user__name">
                                {{ $message->senderProfile->user->name }}
                            </p>
                        </div>

                        {{-- チャット本文 --}}
                        <div class="chat-bubble">
                            @if ($message->message)
                                {{ $message->message }}
                            @endif
                        </div>
                        @if ($message->chat_image)
                            <img class="chat-image" src="{{ asset('storage/' . $message->chat_image) }}" alt="チャット画像">
                        @endif


                        @if ($isMine)
                            <div class="chat-actions">
                                <a class="action-edit"
                                    href="{{ route('chat.edit', ['chatMessage' => $message->id, 'transaction' => $transaction->id]) }}">編集</a>
                                <a class="action-delete" href="{{ route('chat.destroy', $message->id) }}"
                                    onclick="return confirm('削除しますか？')">
                                    削除
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="error-message">
                    @error('message')
                        {{ $message }}
                    @enderror

                    @error('chat_image')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>



                <div class="chat-page__form">
                    <input class="chat-page__text" type="text" name="message" placeholder="取引メッセージを記入してください"
                        value="{{ session('message') }}">
                    <div class="chat-image__area">
                        <label class="chat-image__label" for="fileupload">画像を追加</label>
                        <input class="chat-image__input" type="file" name="chat_image" id="fileupload">
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
