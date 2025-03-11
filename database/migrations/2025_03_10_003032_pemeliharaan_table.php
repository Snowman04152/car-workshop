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
        Schema::create('pemeliharaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servis_id')->references('id')->on('servis');
            $table->string('usia_mesin');
            $table->string('kerusakan');
            $table->string('jam_operasi_perbulan');
            $table->string('bulan_terakhir_servis');
            $table->string('hapus_id');
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
