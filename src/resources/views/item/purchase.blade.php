@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item/purchase.css') }}">
@endsection

@section('content')
    <div class="purchase-page_left">
        <div class="purchase-page__left-inner">
            <div class="purchase-page__item">
                <div class="item-card">
                    <img src="{{ asset($item->item_image) }}" alt="商品画像">
                </div>
                <div class="item-name">
                    <p>{{ $item->name }}</p>
                </div>
                <div class="item-price">
                    <p><span class="yen-mark">¥</span>{{ $item->price }}</p>
                </div>
            </div>
            <div class="purchase-page__payments">
                <label class="payments-title" for="">支払い方法</label>
                <select>
                    <option hidden>選択してください</option>
                    @foreach ($purchases as $purchase)
                        <option value="{{ $purchase->id }}">
                            {{ $purchase->payment_method }}
                        </option>
                    @endforeach
                </select>
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
                <p class="user-address__content"></p>
            </div>
        </div>

        <div class="purchase-page_right">
            <div class="purchase-page__right-inner">
                <table>
                    <tr>
                        <th>商品代金</th>
                        <td><span class="yen-mark__sub">¥</span>{{$item->price}}</td>
                    </tr>
                    <tr>
                        <th>支払い方法</th>
                        <td>(仮)</td>
                    </tr>
                </table>
                <form class="purchase-page__btn" action="">
                    <input class="purchase-btn btn" type="submit" value="購入する">
                </form>

            </div>


        </div>





    </div>
@endsection
