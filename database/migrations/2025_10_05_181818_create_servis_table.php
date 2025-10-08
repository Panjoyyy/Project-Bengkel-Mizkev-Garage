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
            $table->id('id_servis');
            $table->string('keluhan');
            $table->dateTime('tanggal_servis');
            $table->timestamps();

            // Foreign key ke tabel terkait
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
