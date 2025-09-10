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
        Schema::create('registrasi_pasien', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_rm');
            $table->string('nama_pasien');
            $table->string('tanggal_daftar');
            $table->enum('status_bayar', ['SUDAH BAYAR', 'BELUM BAYAR'])->default('BELUM BAYAR');
            $table->decimal('total_biaya', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_pasien');
    }
};
