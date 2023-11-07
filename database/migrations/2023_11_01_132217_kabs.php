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
        Schema::create('kabs', function (Blueprint $table) {
            $table->string('kode_kab')->primary();
            $table->string('kode_prov');
            $table->string('nama_kab');
            $table->foreign('kode_prov')->references('kode_prov')->on('provs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kabs');
    }
};
