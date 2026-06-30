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
        Schema::create('booking', function (Blueprint $table) {
            $table->string('id_booking')->primary();
            $table->integer('id_user');
            $table->string('id_ruangan');
            $table->integer('id_admin')->nullable();
            $table->date('tanggal_booking');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('durasi');
            $table->enum('status_booking', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
