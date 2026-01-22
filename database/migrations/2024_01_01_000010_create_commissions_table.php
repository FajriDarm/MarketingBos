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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('affiliate_id');
            $table->unsignedBigInteger('stage_id');
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'ready_for_withdraw', 'paid'])->default('pending');
            $table->unsignedBigInteger('approved_by')->nullable()->comment('Sales yang approve');
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->date('payout_date')->nullable()->comment('Tanggal payout di akhir bulan');
            $table->timestamps();
            
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('affiliate_id')->references('id')->on('users');
            $table->foreign('stage_id')->references('id')->on('commission_stages');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('rejected_by')->references('id')->on('users')->onDelete('set null');
            
            $table->index(['affiliate_id', 'status']);
            $table->index('status');
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
