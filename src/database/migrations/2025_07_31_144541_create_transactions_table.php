<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('buyer_profile_id')->constrained('profiles')->cascadeOnDelete();
            $table->foreignId('seller_profile_id')->constrained('profiles')->cascadeOnDelete();
            $table->tinyInteger('payment_method')->comment('1=コンビニ支払い 2=カード支払い')->nullable(false);
            $table->tinyInteger('status')->comment('0:購入完了,1:取引完了,2:評価完了');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
