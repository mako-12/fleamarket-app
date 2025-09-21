@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/purchase.css') }}">
@endsection

@section('content')
    <div class="purchase-page">
        <div class="purchase-page__left-inner">
            <div class="purchase-page__item">
                <div class="item-card">
                    <img src="{{ asset('storage/' . $item->item_image) }}" alt="商品画像">
                </div>
                <div class="item-area">
                    <div class="item-name">
                        <p>{{ $item->name }}</p>
                    </div>
                    <div class="item-price">
                        <p><span class="yen-mark">¥</span>{{ $item->price }}</p>
                    </div>
                </div>
            </div>


            <form class="purchase-page__btn" action="{{ route('purchase.store', ['item_id' => $item->id]) }}"
                method="POST">
                @csrf


                <div class="purchase-page__payments">
                    <label class="payments-title" for="">支払い方法</label>
                    <div class="select__wrapper">
                        <select class="payment_method" name="payment_method" id="payment-select">
                            <option hidden>選択してください</option>
                            @foreach (\App\Models\Purchase::$methods as $value => $label)
                                <option value="{{ $value }}">✓ {{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="payments__error-message error-message">
                        @error('payment_method')
                            {{ $message }}
                        @enderror
                    </div>
                </div>



                {{-- 配送先 --}}
                <div class="address-page">
                    <div class="purchase-page__address">
                        <label class="shopping-address__title">配送先</label>
                    </div>
                    <div class="address-change">
                        <a class="address-change__btn" href="{{ route('editAddress', ['item_id' => $item->id]) }}">変更する</a>
                    </div>
                </div>
                {{-- ユーザーのアドレスを表示する 認証してから記述 --}}
                <div class="user-address__top">
                    <div class="user-address__inner">
                        <div class="user-address">
                            <p class="user-address__post-code"><span
                                    class="post-code-mark">〒</span>{{ $address->post_code }}
                            </p>
                        </div>
                        <div class="user-address__address" name="address">
                            {{ $address->address }}
                            {{ $address->building }}
                        </div>
                        <div class="payments__error-message error-message">
                            @error('address')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>


                {{-- <div class="user-address__post-code">
                        <input type="hidden" name="post_code" value="{{ $address->post_code }}">
                    </div>
                    <div class="user-address__address">
                        <input type="hidden" name="address" value="{{ $address->address }}">
                        <input type="hidden" name="building" value="{{ $address->building }}">
                    </div> --}}

        </div>

        <div class="purchase-page_right">
            <div class="purchase-page__right-inner">
                <table>
                    <tr>
                        <th>商品代金</th>
                        <td><span class="yen-mark__sub">¥</span>{{ number_format($item->price) }}</td>
                    </tr>
                    <tr>
                        <th>支払い方法</th>
                        <td id="payment-display"></td>
                    </tr>
                </table>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const selectBox = document.getElementById('payment-select');
                        const display = document.getElementById('payment-display');
                        display.textContent = '';

                        selectBox.addEventListener('change', function() {
                            display.textContent = selectBox.options[selectBox.selectedIndex].text;
                        });
                    });
                </script>
                <div class="purchase-btn">
                    <input class="purchase-btn__submit btn" type="submit" value="購入する">
                </div>
            </div>
        </div>
        </form>

    </div>
@endsection
