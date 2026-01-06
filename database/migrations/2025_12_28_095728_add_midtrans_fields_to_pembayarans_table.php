<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->string('payment_type')->default('manual')->after('metode_pembayaran'); // manual, midtrans
            $table->string('midtrans_order_id')->nullable()->after('payment_type');
            $table->string('midtrans_transaction_id')->nullable()->after('midtrans_order_id');
            $table->string('midtrans_transaction_status')->nullable()->after('midtrans_transaction_id');
            $table->text('midtrans_response')->nullable()->after('midtrans_transaction_status');
            $table->timestamp('paid_at')->nullable()->after('tanggal_bayar');
        });
    }

    public function down(): void
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn([
                'payment_type',
                'midtrans_order_id',
                'midtrans_transaction_id',
                'midtrans_transaction_status',
                'midtrans_response',
                'paid_at'
            ]);
        });
    }
};