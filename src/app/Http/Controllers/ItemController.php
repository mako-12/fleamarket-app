<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Comment;
use App\Models\Purchase;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use App\Models\ItemCondition;
use App\Http\Requests\ItemRequest;
use Stripe\StripeClient;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'recommend');
        $items = Item::all();
        return view('item.index', compact('items', 'tab'));
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
        $purchases = Purchase::all();
        $user = auth()->user();
        $address = $user->profile->address;
        return view('item.purchase', compact('item', 'purchases', 'address'));
    }


    //購入機能
    // public function purchaseStore(Request $request,$item_id)
    // {
    //     $purchase = Purchase::create([
    //         'profile_id' => auth()->user()->profile->id,
    //         'item_id'=>$item_id,
    //         'payment_method' => $request->payment_method,
    //     ]);

    //     return redirect()->route('home');
    // }


    public function purchaseStore(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

        $checkout = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card', 'konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => $item->price * 1500000,
                    'product_data' => [
                        'name' => $item->name,
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success', ['item_id' => $item->id]),
            'cancel_url' => route('purchase.cancel'),
            'metadata' => [
                'profile_id' => auth()->user()->profile->id,
                'item_id' => $item->id,
            ],

        ]);

        return redirect($checkout->url);
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

        $item->itemCategories()->attach($request->item_category_ids);

        return redirect()->route('mypage');
    }
}
