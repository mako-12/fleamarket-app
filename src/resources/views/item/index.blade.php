@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/index.css') }}">
@endsection


@section('content')
    <div class="top-page">
        <input type="radio" name="tab-btn" id="tab-recommend" {{ $tab === 'recommend' ? 'checked' : '' }}>
        <input type="radio" name="tab-btn" id="tab-mylist" {{ $tab === 'mylist' ? 'checked' : '' }}>

        <div class="tab">
            <label for="tab-recommend" class="tab__label"
                onclick="window.location='{{ route('home', ['tab' => 'recommend', 'keyword' => request('keyword')]) }}'">おすすめ</label>
            <label for="tab-mylist" class="tab__label"
                onclick="window.location='{{ route('home', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}'">マイリスト</label>
        </div>


        <div class="tab-page">
            <div class="tab-panel" id="panel-recommend">
                <div class="tab-panel__inner">
                    <div class="recommend-panel">
                        @foreach ($items as $item)
                            @if (!auth()->check() || optional(auth()->user()->profile)->id != $item->profile_id)
                                <div class="item__card">
                                    <a href="/item/{{ $item->id }}"><img
                                            src="{{ asset('storage/' . $item->item_image) }}" alt="商品画像">
                                    </a>
                                    <div class="item__name">{{ $item->name }}
                                    </div>
                                    <div class="sold">
                                        @if ($item->purchases)
                                            <div class="sold">
                                                <span class="sold-label">Sold</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>


            <div class="tab-panel" id="panel-mylist">
                <div class="tab-panel__inner">
                    <div class="mylist-panel">
                        @if ($profile)
                            @foreach ($items as $item)
                                @if ($item->favoriteBy->contains($profile))
                                    <div class="item__card">
                                        <a href="/item/{{ $item->id }}"><img
                                                src="{{ asset('storage/' . $item->item_image) }}" alt="商品画像">
                                        </a>
                                        <div class="item__name">{{ $item->name }}
                                        </div>
                                        <div class="sold">
                                            @if ($item->purchases)
                                                <div class="sold">

                                                    <span class="sold-label">Sold</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
