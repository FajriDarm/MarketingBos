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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code', 50)->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('affiliate_id')->nullable()->comment('Referral dari affiliate');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('sales_id')->nullable()->comment('Sales yang handle');
            $table->decimal('total_amount', 12, 2);
            $table->decimal('dp_amount', 12, 2)->nullable();
            $table->timestamp('dp_paid_at')->nullable();
            $table->string('dp_proof_url', 500)->nullable();
            $table->enum('status', ['pending', 'dp_paid', 'shipped', 'completed', 'cancelled'])->default('pending');
            $table->string('shipping_proof_url', 500)->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('affiliate_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('sales_id')->references('id')->on('users')->onDelete('set null');
            
            $table->index('affiliate_id');
            $table->index('sales_id');
            $table->index('status');
            $table->index('transaction_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
