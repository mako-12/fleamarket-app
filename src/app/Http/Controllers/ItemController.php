<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\ItemCategory;
use Illuminate\Http\Request;
use App\Models\ItemCondition;

class ItemController extends Controller
{
    public function index()
    {
        
        $items = Item::all();
        return view('item.index', compact('items'));
    }

    public function show($item_id)
    {
        $item = Item::with([
            'itemCondition',
            'itemCategories',
            'comments.profile',
            'comments',
        ])->findOrFail($item_id);
        return view('item.show', compact('item'));
    }

    // 購入画面へアクセス
    public function purchase($item_id)
    {
        $item = Item::findOrFail($item_id);
        $purchases = Purchase::all();
        return view('item.purchase', compact('item','purchases'));
    }


    //商品出品画面へアクセス
    public function create()
    {
        $categories = itemCategory::all();
        $conditions = itemCondition::all();
        return view('item.create', compact('categories', 'conditions'));
    }
}
