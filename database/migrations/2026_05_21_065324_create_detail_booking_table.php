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
            $table->id('id_detail');
            $table->string('id_booking');
            $table->decimal('total_bayar', 12, 2);
            $table->string('status_pembayaran')->default('pending');
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();

            $table->foreign('id_booking')->references('id_booking')->on('booking')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_booking');
    }
};
