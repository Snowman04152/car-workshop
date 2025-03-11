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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('original_filename')->nullable();
            $table->string('encrypted_filename')->nullable();
            $table->string('nama_kendaraan');
            $table->foreignId('id_jenis')->references('id')->on('jenis');;
            $table->foreignId('id_merk')->references('id')->on('merks');;
            $table->string('jumlah');
            $table->string('hapus_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');

    }
};
