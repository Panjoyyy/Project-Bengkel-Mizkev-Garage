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
            $table->date('tanggal_servis');
            $table->text('keluhan');
            $table->foreignId('id_motor')->nullable()->constrained('motors', 'id_motor')->cascadeOnNull();
            $table->foreignId('id_mekanik')->nullable()->constrained('mechanics', 'id_mekanik')->cascadeOnNull();
            $table->foreignId('id_user')->nullable()->constrained('users', 'id_user')->cascadeOnNull();
            $table->timestamps();
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
