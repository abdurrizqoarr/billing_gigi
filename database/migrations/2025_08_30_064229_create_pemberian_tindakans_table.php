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
        Schema::create('pemberian_tindakan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pasien_id');
            $table->unsignedBigInteger('tindakan_id');
            $table->string('tarif_tindakan');
            $table->decimal('nilai_tarif', 10, 2);
            $table->timestamps();

            $table->foreign('pasien_id')->references('id')->on('registrasi_pasien')->cascadeOnDelete();
            $table->foreign('tindakan_id')->references('id')->on('tarif_tindakan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberian_tindakan');
    }
};
