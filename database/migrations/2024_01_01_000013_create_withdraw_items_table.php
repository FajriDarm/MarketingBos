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
        Schema::create('withdraw_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('withdraw_request_id');
            $table->unsignedBigInteger('commission_id');
            $table->decimal('amount', 12, 2);
            $table->timestamps();
            
            $table->foreign('withdraw_request_id')->references('id')->on('withdraw_requests')->onDelete('cascade');
            $table->foreign('commission_id')->references('id')->on('commissions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_items');
    }
};
