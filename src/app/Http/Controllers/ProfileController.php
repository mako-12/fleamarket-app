<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Address;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'sell');
        $profile = auth()->user()->profile;
        $items = $profile->items;
        $purchases = $profile->purchases()->with('item')->get();

        return view('profile.show', compact('profile', 'items', 'tab', 'purchases'));
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        return view('address.edit', compact('item'));
    }


    //住所の更新の書き込み
    public function updateAddress(AddressRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        $address = auth()->user()->profile->address;
        $address->update([
            'post_code' => $request->post_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase', ['item_id' => $item->id]);
    }


    public function setup()
    {
        $user = Auth::user();
        $profile = auth()->user()->profile;
        $address = optional($profile)->address;
        return view('profile.setup', compact('user', 'profile', 'address'));
    }

    //プロフィール設定画面の内容の保存
    public function profileCreate(ProfileRequest $request)
    {
        $profile = Auth::user()->profile;

        if ($profile) {
            // 更新処理
            $profile->address->update([
                'post_code' => $request->post_code,
                'address' => $request->address,
                'building' => $request->building,
            ]);

            if ($request->hasFile('profile_image')) {
                $path = $request->file('profile_image')->store('profile_image', 'public');
                $profile->profile_image = $path;
            }

            $profile->name = $request->name;
            $profile->save();
        } else {
            // 初回登録処理
            $address = Address::create([
                'post_code' => $request->post_code,
                'address' => $request->address,
                'building' => $request->building,
            ]);

            $path = $request->hasFile('profile_image')
                ? $request->file('profile_image')->store('profile_image', 'public')
                : 'profile_image/kkrn_icon_user_4.png';

            Profile::create([
                'profile_image' => $path,
                'name' => $request->name,
                'address_id' => $address->id,
                'user_id' => Auth::id(),
            ]);
        }
        return redirect()->route('home');
    }
}
