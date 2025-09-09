@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/purchase.css') }}">
@endsection

@section('content')
    <div class="purchase-page_left">
        <div class="purchase-page__left-inner">
            <div class="purchase-page__item">
                <div class="item-card">
                    <img src="{{ asset('storage/' . $item->item_image) }}" alt="商品画像">
                </div>
                <div class="item-name">
                    <p>{{ $item->name }}</p>
                </div>
                <div class="item-price">
                    <p><span class="yen-mark">¥</span>{{ $item->price }}</p>
                </div>
            </div>


            <form class="purchase-page__btn" action="{{ route('purchase.store', ['item_id' => $item->id]) }}"
                method="POST">
                @csrf


                <div class="purchase-page__payments">
                    <label class="payments-title" for="">支払い方法</label>
                    <select name="payment_method" id="payment-select">
                        <option hidden>選択してください</option>
                        @foreach (\App\Models\Purchase::$methods as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="payments__error-message">
                    @error('purchase_id')
                        {{ $message }}
                    @enderror
                </div>

                {{-- 配送先 --}}
                <div class="purchase-page__address">
                    <label class="shopping-address__title">配送先</label>
                </div>
                <div class="address-change">
                    <a class="address-change__btn" href="{{ route('editAddress', ['item_id' => $item->id]) }}">変更する</a>
                </div>

                {{-- ユーザーのアドレスを表示する 認証してから記述 --}}
                <div class="user-address">
                    <p class="user-address__post-code"><span class="post-code-mark">〒</span>{{ $address->post_code }}</p>
                </div>
                <div class="user-address__address">
                    {{ $address->address }}
                    {{ $address->building }}
                </div>
        </div>

        <div class="purchase-page_right">
            <div class="purchase-page__right-inner">
                <table>
                    <tr>
                        <th>商品代金</th>
                        <td><span class="yen-mark__sub">¥</span>{{ $item->price }}</td>
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



                <input class="purchase-btn btn" type="submit" value="購入する">
                </form>

            </div>


        </div>





    </div>
@endsection
