<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan kolom pendukung Midtrans dan detail_pembayaran ke tabel transaction,
     * serta memperluas enum metode_pembayaran agar menerima 'Pembayaran Online'.
     */
    public function up(): void
    {
        Schema::table('transaction', function (Blueprint $table) {
            // Kolom tambahan untuk Midtrans
            $table->string('snap_token')->nullable()->after('status_pembayaran');
            $table->string('midtrans_order_id')->nullable()->after('snap_token');
            $table->string('midtrans_payment_type')->nullable()->after('midtrans_order_id');
            $table->string('midtrans_transaction_status')->nullable()->after('midtrans_payment_type');
            $table->timestamp('payment_expired_at')->nullable()->after('midtrans_transaction_status');

            // Kolom yang sudah direferensi di view management-transaction tapi belum ada
            $table->string('detail_pembayaran')->nullable()->after('payment_expired_at');
        });

        // Perluas enum metode_pembayaran agar menerima 'Pembayaran Online'.
        // Laravel Blueprint tidak mendukung modifikasi enum secara native tanpa doctrine/dbal,
        // sehingga kita gunakan raw SQL yang kompatibel dengan MySQL/MariaDB.
        DB::statement("
            ALTER TABLE `transaction`
            MODIFY COLUMN `metode_pembayaran`
            ENUM('Cash', 'QRIS', 'Transfer', 'Pembayaran Online') NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan enum ke nilai semula sebelum menghapus kolom
        DB::statement("
            ALTER TABLE `transaction`
            MODIFY COLUMN `metode_pembayaran`
            ENUM('Cash', 'QRIS', 'Transfer') NOT NULL
        ");

        Schema::table('transaction', function (Blueprint $table) {
            $table->dropColumn([
                'snap_token',
                'midtrans_order_id',
                'midtrans_payment_type',
                'midtrans_transaction_status',
                'payment_expired_at',
                'detail_pembayaran',
            ]);
        });
    }
};
