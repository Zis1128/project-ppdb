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
        Schema::table('pembayarans', function (Blueprint $table) {
            // Midtrans specific columns
           
            $table->string('midtrans_order_id', 100)->nullable()->after('payment_type');
            $table->string('midtrans_transaction_id', 100)->nullable()->after('midtrans_order_id');
            $table->string('midtrans_transaction_status', 50)->nullable()->after('midtrans_transaction_id');
            $table->text('midtrans_response')->nullable()->after('midtrans_transaction_status');
            $table->timestamp('paid_at')->nullable()->after('tanggal_bayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn([
                
                'midtrans_order_id',
                'midtrans_transaction_id',
                'midtrans_transaction_status',
                'midtrans_response',
                'paid_at',
            ]);
        });
    }
};