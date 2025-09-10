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
        Schema::create('pemberian_diskon', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pasien_id');
            $table->string('diskon');
            $table->decimal('harga', 10, 2);
            $table->timestamps();

            $table->foreign('pasien_id')->references('id')->on('registrasi_pasien')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberian_diskon');
    }
};
