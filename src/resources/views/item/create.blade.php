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
                    <div class="item-image__choice-btn">
                        <label for="fileupload">画像を選択する</label>
                        <input class="file-upload" type="file" name="item_image" id="fileupload" accept="image/*">
                    </div>
                    <div class="item-image__preview">
                        <img src="#" alt="画像プレビュー" id="preview" style="display: none; max-width: 100px;">
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
                        <div class="item-category__error-message error-message">
                            @error('categories')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="item-condition">
                        <h3 class="item-condition__title title">商品の状態</h3>
                        <select name="item_condition_id" id="" class="item-condition__select">
                            <option value="" hidden>選択してください</option>
                            @foreach ($conditions as $condition)
                                <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                            @endforeach
                        </select>
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
                        <div class="item-name__title title">商品名</div>
                        <div class="item-name__input">
                            <input type="text" name="name" id="">
                        </div>
                        <div class="item-name__error-message error-message">
                            @error('name')
                                {{ $message }}
                            @enderror
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
