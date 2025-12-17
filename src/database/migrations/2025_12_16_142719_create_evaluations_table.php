<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('evaluator_profile_id')->constrained('profiles')->cascadeOnDelete();
            $table->unique(['transaction_id', 'evaluator_profile_id']);
            $table->foreignId('evaluated_profile_id')->constrained('profiles')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating')->default(3)->nullable(false);
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
        Schema::dropIfExists('evaluations');
    }
}
