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
        Schema::create('servis', function (Blueprint $table) {
            $table->string('id_servis', 20)->primary();
            $table->string('keluhan');
            $table->dateTime('tanggal_servis');
            
            // Foreign key ke tabel terkait
            $table->string('id_motor', 20)->nullable();
            $table->foreign('id_motor')->references('id_motor')->on('motors')->onDelete('set null');
            $table->string('id_mechanic', 20)->nullable();
            $table->foreign('id_mechanic')->references('id_mechanic')->on('mechanics')->onDelete('set null');
            $table->string('id_staff', 20)->nullable();
            $table->foreign('id_staff')->references('id_staff')->on('staff')->onDelete('set null');
            $table->timestamps();
            $table->foreignId('id_customer')->constrained('customers', 'id_customer');
            $table->foreignId('id_motor')->nullable()->constrained('motors', 'id_motor')->cascadeOnNull();
            $table->foreignId('id_mechanic')->nullable()->constrained('mechanics', 'id_mechanic')->cascadeOnNull();
            $table->foreignId('id_staff')->nullable()->constrained('staff', 'id_staff')->cascadeOnNull();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servis');
    }
};
