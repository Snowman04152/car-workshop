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
        Schema::create('pemakaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->references('id')->on('kendaraans');
            $table->string('nama_supir');
            $table->date('hari');
            $table->time('jam_keluar');
            $table->time('jam_kembali');
            $table->integer('km_harian');
            $table->integer('history_jumlah')->nullable();
            $table->integer('history_kendaraan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
