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
        Schema::table('servis', function (Blueprint $table) {
             $table->enum('status_servis', ['Sedang Dikerjakan', 'Selesai'])
              ->default('Sedang Dikerjakan')
              ->after('tanggal_servis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('servis', function (Blueprint $table) {
            $table->dropColumn('status_servis');
        });
    }
};
