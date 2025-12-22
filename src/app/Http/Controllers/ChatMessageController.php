<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\ChatMessageRequest;

class ChatMessageController extends Controller
{
    //チャット画面
    public function index(Transaction $transaction)
    {
        $profileId = auth()->user()->profile->id;
        abort_unless(
            $transaction->buyer_profile_id === $profileId || $transaction->seller_profile_id === $profileId,
            403
        );

        // 出品者か？
        $isSeller = $transaction->seller_profile_id === $profileId;

        // 出品者評価モーダルを出すか？
        $showSellerEvaluationModal =
            $isSeller
            && $transaction->status === Transaction::TRANSACTION_COMPLETE
            && ! $transaction->sellerEvaluation;


        //既読処理
        ChatMessage::where('transaction_id', $transaction->id)
            ->where('sender_profile_id', '!=', $profileId)
            ->where('is_read', false)
            ->update(['is_read' => true]);


        //その他の取引
        $sidebarTransactions = Transaction::where('seller_profile_id', $profileId)
            ->whereIn('status', [
                Transaction::PURCHASE_COMPLETE,
                Transaction::TRANSACTION_COMPLETE,
            ])
            ->with('item')
            ->withMax('chatMessages', 'created_at')
            ->orderByDesc('chat_messages_max_created_at')
            ->get();

        // $draft = session('chat_message');

        return view('chat.base', [
            'transaction' => $transaction,
            'messages' => $transaction->chatMessages()->oldest()->get(),
            'myProfileId' => $profileId,
            'showSellerEvaluationModal' => $showSellerEvaluationModal,
            'sidebarTransactions' => $sidebarTransactions,
            // 'draft' => $draft,
        ]);
    }


    //メッセージ送信
    public function store(ChatMessageRequest $request, Transaction $transaction)
    {
        $path = null;

        // ① 画像があれば保存
        if ($request->hasFile('chat_image')) {
            $path = $request->file('chat_image')->store('chat_images', 'public');
        }

        ChatMessage::create([
            'transaction_id' => $transaction->id,
            'sender_profile_id' => auth()->user()->profile->id,
            'message' => $request->message,
            'chat_image' => $path,
            'is_read' => false,
        ]);

        return back()->withInput();
    }
    public function modal(Transaction $transaction)
    {
        return redirect()
            ->route('chat.index', ['transaction' => $transaction->id])
            ->with('showBuyerEvaluationModal', true);
    }

    public function sellerModal(Transaction $transaction)
    {
        $user = auth()->user()->profile->id;

        $showReviewModal = false;

        if ($transaction->status === Transaction::TRANSACTION_COMPLETE && $user->id === $transaction->seller_profile_id) {
            $showReviewModal = true;
        }

        return view('chat.index', compact('transaction', 'showReviewModal'));
    }

    public function update(Request $request, ChatMessage $chatMessage)
    {
        if ($chatMessage->sender_profile_id !== auth()->user()->profile->id) {
            abort(403);
        }
        $request->validate(['message' => 'required|string|max:400',]);
        $chatMessage->update(['message' => $request->message,]);
        return redirect()->back();
    }

    public function edit(ChatMessage $chatMessage, Transaction $transaction)
    {
        if ($chatMessage->sender_profile_id !== auth()->user()->profile->id) {
            abort(403);
        }
        return view('chat.edit', compact('chatMessage', 'transaction'));
    }

    public function destroy(ChatMessage $chatMessage)
    {
        if ($chatMessage->sender_profile_id !== auth()->user()->profile->id) {
            abort(403);
        }
        $chatMessage->delete();
        return redirect()->back();
    }
}
