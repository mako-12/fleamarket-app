@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/index.css') }}">
@endsection


@section('content')
    <div class="top-page">
        <input type="radio" name="tab-btn" id="tab-recommend" checked>
        <input type="radio" name="tab-btn" id="tab-mylist">

        <div class="tab">
            <label for="tab-recommend" class="tab__label">おすすめ</label>
            <label for="tab-mylist" class="tab__label">マイリスト</label>
        </div>

        <div class="tab-page">
            <div class="tab-panel" id="panel-recommend">
                <div class="tab-panel__inner">
                    <div class="recommend-panel">
                        @foreach ($items as $item)
                            <div class="item__card">
                                <a href="/item/{{ $item->id }}"><img src="{{ asset($item->item_image) }}"
                                        alt="商品画像">
                                </a>
                                <div class="item__name">{{ $item->name }}
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="tab-panel" id="panel-mylist">
                <div class="tab-panel__inner">
                    <p>2page</p>
                </div>

            </div>
        </div>
    </div>
@endsection
