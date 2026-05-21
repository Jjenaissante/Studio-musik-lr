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
        Schema::create('ruangan', function (Blueprint $table) {
            $table->string('id_ruangan')->primary();
            $table->string('id_studio');
            $table->string('nama_ruangan');
            $table->integer('kapasitas');
            $table->decimal('tarif_per_jam', 12, 2);
            $table->string('status')->default('available');
            $table->timestamps();

            $table->foreign('id_studio')->references('id_studio')->on('studio')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
