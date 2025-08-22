@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/create.css') }}">
@endsection


@section('content')
    <div class="listing-page">
        <div class="item-card">
            <h2 class="listing-page__title">
                商品の出品
            </h2>
            <h3 class="item-card__title title">
                商品画像
            </h3>

            <form class="upload" action="/upload" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="item-image__choice-btn">
                    <label for="fileupload">画像を選択する</label>
                    <input class="file-upload" type="file" name="item-image" id="fileupload">
                </div>

                <div class="item-detail">
                    <div class="item-detail__title">
                        <p class="sub-title">商品の詳細</p>
                    </div>
                    <div class="item-category">
                        <div class="category-title title">
                            カテゴリー
                        </div>
                        <div class="item-categories">
                            @foreach ($categories as $category)
                                <label for="">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="">
                                    {{ $category->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="item-condition">
                        <h3 class="item-condition__title title">商品の状態</h3>

                        <select name="item_condition_id" id="" class="item-condition__select">
                            <option hidden>選択してください</option>
                            @foreach ($conditions as $condition)
                                <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="item-explanation">
                    <div class="item-explanation__title">
                        <p class="sub-title">商品名と説明</p>
                    </div>
                    <div class="item-listing__group">
                        <div class="item-name__title title">商品名</div>
                        <div class="item-name__input">
                            <input type="text" name="name" id="">
                        </div>
                    </div>

                    <div class="item-listing__group">
                        <div class="item-name__title title">
                            ブランド名
                        </div>
                        <div class="item-brand__input">
                            <input type="text" name="brand" id="">
                        </div>
                    </div>
                    <div class="item-listing__group">
                        <div class="item-name__title title">
                            商品の説明
                        </div>
                        <textarea name="detail" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="item-listing__group">
                        <div class="item-name__title title">
                            販売金額
                        </div>
                        <div class="item-price__input">
                            <span class="yen-mark">¥</span>
                            <input class="price-box" type="text" name="price" id="">
                        </div>
                    </div>
                </div>
                <div class="listing-page__btn">
                    <input class="listing-submit btn" type="submit" name="" id="" value="出品する">
                </div>










            </form>
        </div>
    </div>
@endsection
