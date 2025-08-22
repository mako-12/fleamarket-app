@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/show.css') }}">
@endsection


@section('content')
    <div class="item-panel">
        <div class="item-card">
            <img src="{{ asset($item->item_image) }}" alt="商品画像">
        </div>
        <div class="item-content">
            <div class="item-name">
                <h1>{{ $item->name }}</h1>
            </div>
            <div class="item-brand">
                <p>{{ $item->brand }}</p>
            </div>
            <div class="item-price">
                <p>&yen;{{ number_format($item->price) }}
                    <span class="tax">(税込み)</span>
                </p>
            </div>
            <div class="item-content__actions">

                <div class="actions-btn">
                    <div class="item-content__favorite">
                        <button class="favorite-btn">☆</button>
                    </div>
                    <div class="item-content__comment">
                        <button class="comment-btn">〇</button>
                    </div>
                </div>
                <div class="purchase-btn">
                    <a class="purchase-form btn" href="{{ route('purchase', ['item_id' => $item->id]) }}">購入手続きへ</a>
                </div>

                <div class="item-content__sub">
                    {{-- 商品説明 --}}
                    <section>
                        <div class="item-content__item-detail">
                            <div class="item-detail__title title">
                                <h2>商品説明</h2>
                            </div>
                            <div class="item-detail__content">
                                {{ $item->detail }}
                            </div>
                        </div>
                    </section>

                    {{-- 商品の情報 --}}
                    <section>
                        <div class="item-content__item-information">
                            <div class="item-information__title  title">
                                <h2>商品の情報</h2>
                            </div>
                            <dl>
                                <div class="information">
                                    <div class="information-title">
                                        <dt>カテゴリー</dt>
                                    </div>
                                    <div class="category-inner">
                                        <dd>
                                            {{-- カテゴリー内容 --}}
                                            @foreach ($item->itemCategories as $itemCategory)
                                                <div class="category-content">
                                                    {{ $itemCategory->name }}
                                                </div>
                                            @endforeach
                                        </dd>
                                    </div>
                                    <div class="information-title">
                                        <dt>商品の状態</dt>
                                    </div>
                                    <div class="condition-inner">
                                        <div class="condition-content">
                                            {{ $item->itemCondition->name }}
                                        </div>
                                    </div>

                                </div>
                            </dl>
                        </div>
                    </section>
                </div>

                {{-- コメント --}}
                <div class="comment-area">
                    <p class="comment-title">コメント(</p>
                    @forelse($item->comments as $comment)
                        <p>{{ $comments->profile_id }}</p>
                        <p>{{ $comments->comtent }}</p>
                    @empty
                        <p>0</p>
                    @endforelse
                    <p class="comment-title">)</p>
                </div>

                {{-- ユーザーの画像と名前 --}}


                {{-- コメント表示場所 --}}


                {{-- コメント入力欄 --}}
                <form class="comment-form" action="" method="POST">
                    @csrf
                    <p class="comment-title__sub">商品へのコメント</p>
                    <textarea class="comment__textarea" name="content" id="" cols="30" rows="5"></textarea>
                    <input class="comment-btn btn" type="submit" name="content" value="コメントを送信する">
                </form>
            </div>
        </div>
    </div>
@endsection
