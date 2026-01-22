<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payout_batch_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payout_batch_id');
            $table->unsignedBigInteger('withdraw_request_id');
            $table->decimal('amount', 12, 2);
            $table->timestamps();
            
            $table->foreign('payout_batch_id')->references('id')->on('payout_batches')->onDelete('cascade');
            $table->foreign('withdraw_request_id')->references('id')->on('withdraw_requests');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payout_batch_items');
    }
};
