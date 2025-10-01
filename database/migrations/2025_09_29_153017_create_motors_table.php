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
            $table->id('id_motor');
            $table->string('no_plat_motor');
            $table->string('merk_motor');
            $table->string('warna_motor');
            $table->year('tahun_motor');
            $table->timestamps();
            $table->foreignId('id_customer')->nullable()->constrained('customers', 'id_customer')->cascadeOnNull();
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
