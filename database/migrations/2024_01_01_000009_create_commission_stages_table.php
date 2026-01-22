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
        Schema::create('commission_stages', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('stage_number')->comment('1, 2, atau 3');
            $table->string('name', 100)->comment('Chat, DP, Shipped');
            $table->text('description')->nullable();
            $table->decimal('commission_percentage', 5, 2)->comment('Persentase dari total');
            $table->decimal('min_amount', 12, 2)->nullable();
            $table->decimal('max_amount', 12, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_stages');
    }
};
