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
        Schema::create('riwayat_transaksi', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('pegawai');
            $table->uuid(('registrasi_id'));
            $table->unsignedBigInteger(('akun_penerimaan_id'));
            $table->timestamp('waktu_transaksi');
            $table->timestamps();

            $table->foreign('pegawai')->references('id')->on('pegawai')->cascadeOnDelete();
            $table->foreign('registrasi_id')->references('id')->on('registrasi_pasien')->cascadeOnDelete();
            $table->foreign('akun_penerimaan_id')->references('id')->on('akun_penerimaan')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_transaksi');
    }
};
