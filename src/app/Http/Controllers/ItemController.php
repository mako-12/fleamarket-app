<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Models\Item;
use App\Models\Comment;
use App\Models\Purchase;
use App\Models\Transaction;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use App\Models\ItemCondition;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\TransactionRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'recommend');

        $query = Item::with('transactions', 'favoriteBy');


        if (auth()->check() && isset($query)) {
            $profileId = optional(auth()->user()->profile)->id;
            $query->where('profile_id', '!=', $profileId);
        }

        $items = $query->get();

        $profile = auth()->check() ? auth()->user()->profile : null;


        //検索フォーム
        $keyword = $request->input('keyword');
        $tab = $request->input('tab', 'recommend');

        $query = Item::query();
        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        //検索結果の取得
        $items = $query->get();
        $profile = auth()->check() ? auth()->user()->profile : null;


        return view('item.index', compact('items', 'tab', 'profile', 'keyword'));
    }

    public function show($item_id)
    {
        $item = Item::with([
            'itemCondition',
            'itemCategories',
            'comments.profile' => function ($query) {
                $query->latest();
            },
        ])->findOrFail($item_id);

        $profile = auth()->user()->profile ?? null;

        return view('item.show', compact('item', 'profile'));
    }

    // 購入画面へアクセス
    public function purchase($item_id)
    {
        $item = Item::findOrFail($item_id);
        $purchases = Transaction::all();
        $user = auth()->user();
        $address = $user->profile->address;
        return view('item.purchase', compact('item', 'purchases', 'address'));
    }


    //購入機能

    public function purchaseStore(TransactionRequest $request, $item_id)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $item = Item::findOrFail($item_id);

        $payment_method = $request->input('payment_method');

        session([
            'purchased_item_id' => $item->id,
            'payment_method' => $payment_method,
        ]);

        $session = Session::create([
            'payment_method_types' => ['card', 'konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success', ['item_id' => $item->id]),
            'cancel_url' => route('checkout.cancel'),
        ]);
        return redirect($session->url);
    }

    //購入履歴の保存
    public function success(Request $request)
    {
        $item_id = session('purchased_item_id');
        $payment_method = session('payment_method');

        $item = Item::findOrFail($item_id);

        // Purchase::create([
        //     'profile_id' => auth()->user()->profile->id,
        //     'item_id' => $item_id,
        //     'payment_method' => $payment_method,

        // ]);

        $transaction = Transaction::create([
            'buyer_profile_id' => auth()->user()->profile->id,
            'seller_profile_id' => $item->profile_id,
            'item_id' => $item_id,
            'payment_method' => $payment_method,
            'status' => Transaction::PURCHASE_COMPLETE,
        ]);


        // return redirect()->route('home');
        return redirect()->route('chat.index', $transaction->id);
    }




    //商品出品画面へアクセス
    public function create()
    {
        $categories = ItemCategory::all();
        $conditions = itemCondition::all();
        return view('item.create', compact('categories', 'conditions'));
    }


    public function store(ItemRequest $request)
    {
        $path = $request->file('item_image')->store('item_image', 'public');

        $item = Item::create([
            'profile_id' => auth()->user()->profile->id,
            'item_condition_id' => $request->item_condition_id,
            'name' => $request->name,
            'brand' => $request->brand,
            'detail' => $request->detail,
            'price' => $request->price,
            'item_image' => $path,
        ]);

        $item->itemCategories()->attach($request->categories);

        return redirect()->route('mypage');
    }

    //検索
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $tab = $request->input('tab', 'recommend');

        $query = Item::query();
        if (!empty($keyword)) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        //検索結果の取得
        $items = $query->get();
        $profile = auth()->check() ? auth()->user()->profile : null;

        return view('item/index', compact('items', 'keyword', 'profile', 'tab'));
    }
}
