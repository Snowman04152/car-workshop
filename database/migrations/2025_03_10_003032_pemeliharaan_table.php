<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemeliharaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servis_id')->references('id')->on('servis');
            $table->integer('usia_mesin');
            $table->integer('servis_terakhir_bulan');
            $table->integer('jenis_pemeliharaan_1')->nullable();
            $table->integer('jenis_pemeliharaan_2')->nullable();
            $table->integer('jenis_pemeliharaan_3')->nullable();
            $table->integer('interval_km');
            $table->integer('frekuensi_km_harian');
            $table->integer('jam_operasi_bulanan');
            $table->integer('riwayat_masalah');
            $table->integer('bulan_prediksi')->nullable();
            $table->string('hapus_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeliharaans');

    }
};
