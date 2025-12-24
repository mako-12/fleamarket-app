<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Address;
use App\Models\Profile;
use App\Models\Evaluation;
use App\Models\ChatMessage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'sell');
        $profile = auth()->user()->profile;
        // $items = $profile->items;

        if (!$profile) {
            abort(404);
        }

        $items = $profile->items;

        $purchases = $profile->boughtTransactions()->with('item')->get();

        //評価数と平均を取得
        $averageRating = Evaluation::where('evaluated_profile_id', $profile->id)
            ->avg('rating');

        $roundedRating = $averageRating ? round($averageRating) : null;



        //購入者の出品一覧の表示?
        // 購入した商品
        $evaluatedTransactions = Transaction::where('buyer_profile_id', $profile->id)
            ->where('status', Transaction::EVALUATED_COMPLETE)
            ->with('item')
            ->get();


        //PURCHASE_COMPLETE(購入済み)を取得
        $tradingTransactions = Transaction::where(function ($query) use ($profile) {
            $query->where('buyer_profile_id', $profile->id)
                ->orWhere('seller_profile_id', $profile->id);
        })
            ->whereIn('status', [
                Transaction::PURCHASE_COMPLETE,
                Transaction::TRANSACTION_COMPLETE,
            ])
            ->with('item')
            ->withMax('chatMessages', 'created_at')
            ->get();

        // TRANSACTION_COMPLETE(取引完了)を取得
        $completedTransactions = Transaction::where('seller_profile_id', $profile->id)
            ->where('status', Transaction::TRANSACTION_COMPLETE)
            ->with('item')
            ->get();

        // 上記二つをマージ
        $transactions = $tradingTransactions
            ->merge($completedTransactions)
            ->sortByDesc('chat_messages_max_created_at')
            ->values();


        // 未読カウント
        $unreadMessageCount = ChatMessage::whereHas('transaction', function ($query) use ($profile) {
            $query->where(function ($q) use ($profile) {
                $q->where('buyer_profile_id', $profile->id)
                    ->orWhere('seller_profile_id', $profile->id);
            });
        })
            ->where('sender_profile_id', '!=', $profile->id)
            ->where('is_read', false)
            ->count();

        // 商品ごとの未読カウント
        $unreadMessagesByTransaction = ChatMessage::select(
            'transaction_id',
            DB::raw('count(*) as unread_count')
        )
            ->where('sender_profile_id', '!=', $profile->id)
            ->where('is_read', false)
            ->whereHas('transaction', function ($query) use ($profile) {
                $query->where(function ($q) use ($profile) {
                    $q->where('buyer_profile_id', $profile->id)
                        ->orWhere('seller_profile_id', $profile->id);
                })
                    ->whereIN('status', [
                        Transaction::PURCHASE_COMPLETE,
                        Transaction::TRANSACTION_COMPLETE,
                    ]);
            })
            ->groupBy('transaction_id')
            ->pluck('unread_count', 'transaction_id');


        return view('profile.show', compact('profile', 'items', 'tab', 'purchases', 'tradingTransactions', 'completedTransactions', 'evaluatedTransactions', 'unreadMessageCount', 'unreadMessagesByTransaction', 'roundedRating', 'transactions'));
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
