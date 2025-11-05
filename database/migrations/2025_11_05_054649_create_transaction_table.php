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
        Schema::create('transaction', function (Blueprint $table) {
          $table->string('id_transaksi', 20)->primary(); // TRX001
            $table->string('no_nota')->unique();
            $table->string('id_servis', 20);

            // Kolom JSON (bisa simpan banyak id sekaligus)
            $table->json('id_layanan')->nullable();
            $table->json('id_sparepart')->nullable();
            $table->json('jumlah_sparepart')->nullable();

            $table->decimal('harga_layanan', 12, 2)->default(0);
            $table->decimal('harga_sparepart', 12, 2)->nullable();
            $table->decimal('subtotal', 10, 2)->default(0);

            $table->date('tanggal_transaksi');
            $table->enum('metode_pembayaran', ['Cash', 'QRIS', 'Transfer']);
            $table->enum('status_pembayaran', ['Lunas', 'Belum Lunas'])->default('Belum Lunas');

            $table->timestamps();

            $table->foreign('id_servis')->references('id_servis')->on('servis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
