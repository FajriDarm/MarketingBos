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
        Schema::table('users', function (Blueprint $table) {
            // Add new columns to users table
            $table->string('phone', 20)->nullable()->after('password');
            $table->string('bank_name', 100)->nullable()->after('phone');
            $table->string('bank_account', 50)->nullable()->after('bank_name');
            $table->string('bank_account_name', 100)->nullable()->after('bank_account');
            $table->unsignedBigInteger('role_id')->after('bank_account_name');
            $table->unsignedBigInteger('sales_id')->nullable()->comment('Referensi ke Sales jika user adalah affiliate')->after('role_id');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('sales_id');
            $table->decimal('commission_rate', 5, 2)->default(0.00)->comment('Persentase komisi untuk affiliate')->after('status');
            $table->decimal('total_commission', 12, 2)->default(0.00)->after('commission_rate');
            $table->decimal('total_withdrawn', 12, 2)->default(0.00)->after('total_commission');
            $table->date('last_withdraw_date')->nullable()->after('total_withdrawn');
            
            // Add indexes
            $table->index('role_id');
            $table->index('sales_id');
            
            // Add foreign keys
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('sales_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['sales_id']);
            $table->dropIndex(['role_id']);
            $table->dropIndex(['sales_id']);
            
            $table->dropColumn([
                'phone',
                'bank_name',
                'bank_account',
                'bank_account_name',
                'role_id',
                'sales_id',
                'status',
                'commission_rate',
                'total_commission',
                'total_withdrawn',
                'last_withdraw_date'
            ]);
        });
    }
};
