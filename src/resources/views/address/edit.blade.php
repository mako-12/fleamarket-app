@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/address/edit.css') }}">
@endsection


@section('content')
    <div class="address-page__update">
        <div class="address-page__inner">
            <div class="address-page__title">
                <h2>住所の変更</h2>
            </div>

            <div class="update-input">
                <form action="{{ route('updateAddress', ['item_id' => $item->id]) }}" method="POST">
                    @csrf
                    <div class="address-page__group">
                        <div class="input-title">
                            <p>郵便番号</p>
                        </div>
                        <div class="post-code__input input">
                            <input type="text" name="post_code">
                        </div>

                        <div class="post-code__error-message">
                            <div class="error-message">
                                @error('post_code')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="address-page__group">
                        <div class="input-title">
                            <p>住所</p>
                        </div>
                        <div class="address-input input">
                            <input type="text" name="address">
                        </div>
                        <div class="error-message">
                            @error('address')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="address-page__group">
                        <div class="input-title">
                            <p>建物名</p>
                        </div>
                        <div class="building-input input">
                            <input type="text" name="building">
                        </div>
                    </div>

                    <div class="update-btn__inner">
                        <input class="update-submit btn" type="submit" value="更新する" name="" id="">
                    </div>

                </form>
            </div>


        </div>
    </div>
@endsection
