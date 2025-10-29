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
        Schema::create('motors', function (Blueprint $table) {
            $table->string('id_motor', 20)->primary();
            $table->string('no_plat_motor');
            $table->string('merk_motor');
            $table->string('warna_motor');
            $table->year('tahun_motor');
            $table->string('id_customer', 20)->nullable();
            $table->foreign('id_customer')->references('id_customer')->on('customers')->onDelete('set null');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
