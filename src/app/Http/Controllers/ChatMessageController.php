<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Transaction;
use Illuminate\Http\Request;

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

        return view('chat.base', [
            'transaction' => $transaction,
            'messages' => $transaction->chatMessages()->oldest()->get(),
            'myProfileId' => $profileId,
            'showSellerEvaluationModal' => $showSellerEvaluationModal,
        ]);
    }

    //メッセージ送信
    public function store(Request $request, Transaction $transaction)
    {
        ChatMessage::create([
            'transaction_id' => $transaction->id,
            'sender_profile_id' => auth()->user()->profile->id,
            'message' => $request->message,
            'chat_image' => $request->chat_image,
        ]);

        return back();
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
}
