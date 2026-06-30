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
        Schema::create('detail_booking', function (Blueprint $table) {
            $table->string('id_booking', 10)->primary();
            $table->date('tanggal_pembayaran')->nullable();
            $table->decimal('total_bayar', 10, 3);
            $table->enum('metode_pembayaran', ['cash', 'transfer', 'online'])->nullable();
            $table->string('status_pembayaran', 50)->default('pending');
            $table->string('bukti_pembayaran', 255)->nullable();
            $table->timestamps();

            $table->foreign('id_booking')->references('id_booking')->on('booking')->onDelete('cascade');
        });

        Schema::create('ulasan', function (Blueprint $table) {
            $table->integer('id_ulasan')->autoIncrement();
            $table->integer('id_user')->nullable();
            $table->string('id_studio', 10)->nullable();
            $table->integer('rating')->nullable();
        });

        Schema::create('jadwal_ketersediaan', function (Blueprint $table) {
            $table->integer('id_jadwal')->autoIncrement();
            $table->string('id_ruangan', 10)->nullable();
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('status', ['available', 'booked', 'maintenance'])->default('available');
            $table->timestamps();

            $table->foreign('id_ruangan')->references('id_ruangan')->on('ruangan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_booking');
        Schema::dropIfExists('ulasan');
        Schema::dropIfExists('jadwal_ketersediaan');
    }
};
