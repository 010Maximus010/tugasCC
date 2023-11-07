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
        Schema::create('pkls', function (Blueprint $table) {
            $table->string('nim');
            $table->integer('semester_aktif');
            $table->string('nilai')->nullable();
            $table->string('status');
            $table->string('upload_pkl')->nullable();
            $table->unique(['nim', 'semester_aktif']);
            $table->foreign('nim')->references('nim')->on('tb_entry_progresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkls');
    }
};
