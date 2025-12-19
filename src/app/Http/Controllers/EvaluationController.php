<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    //評価画面(モーダル)
    public function create()
    {
        //
    }
    //評価保存
    public function store(Request $request, Transaction $transaction)
    {
        // DB::transaction(function () use ($request, $transaction) {
        //     Evaluation::create([
        //         'transaction_id' => $transaction->id,
        //         'evaluator_profile_id' => auth()->user()->profile->id,
        //         'evaluated_profile_id' => $transaction->seller_profile_id,
        //         'rating' => $request->rating,
        //     ]);

        //     $transaction->update([
        //         'status' => Transaction::TRANSACTION_COMPLETE,
        //         'completed_at' => now(),
        //     ]);
        // });

        DB::transaction(function () use ($request, $transaction) {

            $myProfileId = auth()->user()->profile->id;

            // 今ログインしている人が誰か判定
            $isBuyer  = $myProfileId === $transaction->buyer_profile_id;
            $isSeller = $myProfileId === $transaction->seller_profile_id;

            // 評価される相手を決定
            $evaluatedProfileId = $isBuyer
                ? $transaction->seller_profile_id
                : $transaction->buyer_profile_id;

            // 評価保存
            Evaluation::create([
                'transaction_id' => $transaction->id,
                'evaluator_profile_id' => $myProfileId,
                'evaluated_profile_id' => $evaluatedProfileId,
                'rating' => $request->rating,
            ]);

            // ステータス更新
            if ($isBuyer) {
                // 購入者が評価した段階
                $transaction->update([
                    'status' => Transaction::TRANSACTION_COMPLETE,
                ]);
            } elseif ($isSeller) {
                // 出品者も評価した → 両者評価済み
                $transaction->update([
                    'status' => Transaction::EVALUATED_COMPLETE,
                ]);
            }
        });


        return redirect()->route('mypage');
    }
}
