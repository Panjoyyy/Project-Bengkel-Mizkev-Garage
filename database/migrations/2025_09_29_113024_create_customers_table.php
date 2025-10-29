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
    Schema::create('customers', function (Blueprint $table) {
        $table->string('id_customer', 20)->primary();
        $table->string('nama_customer');
        $table->string('no_telp_customer');
        $table->string('alamat_customer');
        $table->string('email_customer');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('customers');
}
};
