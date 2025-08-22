<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.show', compact('profile'));
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        return view('address.edit', compact('item'));
    }

    //住所の更新の書き込み
    public function updateAddress(Request $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        $address = auth()->user()->address;
        $address->update([
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase', ['item_id' => $item->id]);
    }
}
