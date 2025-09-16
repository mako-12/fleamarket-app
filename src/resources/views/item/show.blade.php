@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/show.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    {{-- <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet"> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('content')
    <div class="item-panel">
        <div class="item-card">
            <img src="{{ asset('storage/' . $item->item_image) }}" alt="商品画像">
        </div>



        <div class="item-content">
            <div class="item-name">
                <h1>{{ $item->name }}</h1>
            </div>
            <div class="item-brand">
                <p>{{ $item->brand }}</p>
            </div>
            <div class="item-price">
                <div class="item-price__yen">&yen;</div>
                <div class="item-price__number">{{ number_format($item->price) }}
                    <span class="tax">(税込)</span>
                </div>

            </div>

            <div class="item-actions-btn">
                <div class="actions-btn">
                    <div class="item-content__favorite">
                        <form action="{{ route('favorite.toggle', $item->id) }}" method="POST">
                            @csrf
                            <button type="button" class="favorite-btn" data-item-id="{{ $item->id }}"
                                @if (!auth()->check()) disabled @endif>
                                @if (auth()->check() && auth()->user()->profile->favoriteItems->contains($item->id))
                                    <i class="fa-solid fa-star favorite-icon fa-2x"></i>
                                @else
                                    <i class="fa-regular fa-star favorite-icon fa-2x"></i>
                                @endif
                            </button>
                        </form>
                        <div class="action-count">
                            <span id="favorite-count-{{ $item->id }}">{{ $item->favoriteBy->count() }}</span>
                        </div>
                    </div>



                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.querySelectorAll('.favorite-btn').forEach(button => {
                                button.addEventListener('click', function() {
                                    const itemId = this.dataset.itemId;
                                    fetch(`/favorite/${itemId}`, {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector(
                                                    'meta[name="csrf-token"]').content,
                                                'Accept': 'application/json',
                                            },
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            const icon = this.querySelector('i');
                                            const countSpan = document.getElementById(
                                                `favorite-count-${itemId}`);

                                            // アイコン切り替え
                                            if (data.status === 'added') {
                                                icon.classList.remove('fa-regular');
                                                icon.classList.add('fa-solid');
                                            } else {
                                                icon.classList.remove('fa-solid');
                                                icon.classList.add('fa-regular');
                                            }

                                            // カウント更新
                                            countSpan.textContent = data.count;
                                        })
                                        .catch(error => console.error(error));
                                });
                            });
                        });
                    </script>




                    <div class="item-content__comment">
                        <i class="far fa-comment comment-icon fa-2x"></i>
                        <div class="action-count">
                            <span>{{ $item->comments->count() }}</span>
                        </div>
                    </div>
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
                                <div class="category-inner">
                                    <div class="information-title">
                                        <dt>カテゴリー</dt>
                                    </div>
                                    <dd class="category-content">
                                        {{-- カテゴリー内容 --}}
                                        @foreach ($item->itemCategories as $itemCategory)
                                            <p class="category-simple">
                                                {{ $itemCategory->name }}
                                            </p>
                                        @endforeach
                                    </dd>
                                </div>

                                <div class="condition-inner">
                                    <div class="information-title">
                                        <dt>商品の状態</dt>
                                    </div>

                                    <div class="condition-content">
                                        {{ $item->itemCondition->name }}
                                    </div>
                                </div>

                            </div>
                        </dl>
                    </div>
                </section>
            </div>

            {{-- コメント数 --}}
            <div class="comment-area">
                <p class="comment-title">コメント({{ $item->comments->count() }})</p>
            </div>

            {{-- コメント一覧 --}}
            @foreach ($item->comments as $comment)
                <div class="comment-box">
                    <div class="user-area">
                        <div class="user-icon">
                            <img class="icon" src="{{ asset('storage/' . $comment->profile->profile_image) }}"
                                alt="プロフィール画像">
                        </div>
                        <div class="user-name">
                            <p>{{ $comment->profile->name }}</p>
                        </div>
                    </div>
                    <div class="comment-content">
                        <p>{{ $comment->content }}</p>
                    </div>
                </div>
            @endforeach



            {{-- コメント入力欄 --}}
            <form class="comment-form" action="{{ route('comment.store', ['item_id' => $item->id]) }}" method="POST">
                @csrf
                <p class="comment-title__sub">商品へのコメント</p>
                <textarea class="comment__textarea" name="content" id="" cols="30" rows="5"></textarea>

                <div class="comment-form__error-message error-message">
                    @error('content')
                        {{ $message }}
                    @enderror
                </div>
                <div class="comment-btn">
                    <input class="comment-btn__submit btn" type="submit" value="コメントを送信する">
                </div>
            </form>
        </div>
    </div>
@endsection
