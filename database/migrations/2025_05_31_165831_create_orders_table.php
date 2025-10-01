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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_order');
           // $table->string('customer_name');
           // $table->string('customer_phone');
            //$table->string('customer_address');
            //$table->string('motor_type');
            // $table->string('license_plate');
            $table->foreignId('id_service')->nullable()->constrained('services', 'id_service')->cascadeOnNull();
            $table->foreignId('id_mechanic')->nullable()->constrained('mechanics', 'id_mechanic')->cascadeOnNull();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
