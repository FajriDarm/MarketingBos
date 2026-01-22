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
        Schema::create('chat_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('sales_id')->nullable()->comment('Sales yang menangani chat');
            $table->text('message');
            $table->enum('sender_type', ['customer', 'sales', 'system']);
            $table->boolean('is_order_intent')->default(false)->comment('Flag untuk intent order');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('sales_id')->references('id')->on('users')->onDelete('set null');
            
            $table->index('transaction_id');
            $table->index('is_order_intent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_histories');
    }
};
