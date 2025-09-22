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

            <form class="upload" action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="item-image">
                    <div class="item-image__preview">
                        <img class="image-preview" src="#" alt="画像プレビュー" id="preview"
                            style="display: none; max-width: 100px;">

                        <div class="item-image__choice-btn">
                            <label class="item-image__label" for="fileupload">画像を選択する</label>
                            <input class="file-upload" type="file" name="item_image" id="fileupload" accept="image/*">
                        </div>
                    </div>

                    <script>
                        document.getElementById('fileupload').addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const preview = document.getElementById('preview');
                                    preview.src = e.target.result;
                                    preview.style.display = 'block';
                                }
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>

                    <div class="item-image__error-message error-message">
                        @error('item_image')
                            {{ $message }}
                        @enderror
                    </div>


                </div>

                <div class="item-detail">
                    <div class="item-detail__title">
                        <p class="sub-title">商品の詳細</p>
                    </div>
                    <div class="item-category">
                        <h3 class="category-title title">
                            カテゴリー
                        </h3>
                        <div class="item-categories">
                            @foreach ($categories as $category)
                                <input class="item-category__checkbox" type="checkbox" name="categories[]"
                                    value="{{ $category->id }}" id="category-{{ $category->id }}">
                                <label class="category-btn" for="category-{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            @endforeach
                        </div>
                        <div class="item-category__error-message error-message">
                            @error('categories')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="item-condition">
                        <h3 class="item-condition__title title">商品の状態</h3>
                        <div class="select__wrapper">
                            <select name="item_condition_id" id="" class="item-condition__select">
                                <option value="" hidden>選択してください</option>
                                @foreach ($conditions as $condition)
                                    <option value="s{{ $condition->id }}">✓{{ $condition->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="item-condition__error-message error-message">
                            @error('item_condition_id')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="item-explanation">
                    <div class="item-explanation__title">
                        <p class="sub-title">商品名と説明</p>
                    </div>
                    <div class="item-listing__group">
                        <h3 class="item-name__title title">商品名</h3>

                        <input class="item-name__input" type="text" name="name" id="">

                        <div class="item-name__error-message error-message">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="item-listing__group">
                        <h3 class="item-name__title title">
                            ブランド名
                        </h3>
                        <input class="item-brand__input" type="text" name="brand" id="">
                    </div>
                    <div class="item-listing__group">
                        <h3 class="item-name__title title">
                            商品の説明
                        </h3>
                        <textarea name="detail" id="" cols="30" rows="10"></textarea>
                        <div class="item-detail_error-message error-message">
                            @error('detail')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="item-listing__group">
                        <div class="item-name__title title">
                            販売金額
                        </div>
                        <div class="item-price__input">
                            <span class="yen-mark">¥</span>
                            <input class="price-box" type="text" name="price" id="">
                        </div>
                        <div class="item-price__error-message error-message">
                            @error('price')
                                {{ $message }}
                            @enderror
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
