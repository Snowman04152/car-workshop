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
        Schema::create(
            'kendaraans',
            function (Blueprint $table) {
                $table->id();
                $table->string('original_filename')->nullable();
                $table->string('encrypted_filename')->nullable();
                $table->string('nama_kendaraan');
                $table->integer('tanggal_masuk');
                $table->string('plat_nomor');
                $table->string('merk');
                $table->string('jenis');
                $table->integer('usia_mesin');
                $table->integer('jam_operasi_perbulan');
                $table->integer('frekuensi_km_harian');
                $table->integer('jenis_pemeliharaan_1');
                $table->integer('jenis_pemeliharaan_2');
                $table->integer('jenis_pemeliharaan_3');
                $table->integer('interval_km');
                $table->integer('riwayat_masalah');
                $table->integer('bulan_terakhir_servis');
                $table->integer('tahun_terakhir_servis');
                $table->integer('bulan_prediksi')->nullable();
                $table->string('hapus_id');
                $table->timestamps();
            }
        );
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');

    }
};
