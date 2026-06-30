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
        Schema::create('notifikasi', function (Blueprint $blueprint) {
            $blueprint->id();
            // id_user harus tipe integer untuk mencocokkan id_user di tabel user
            $blueprint->integer('id_user');
            $blueprint->string('judul');
            $blueprint->text('pesan');
            $blueprint->string('tipe')->nullable();
            $blueprint->boolean('is_read')->default(false);
            $blueprint->timestamps();

            $blueprint->foreign('id_user')->references('id_user')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
