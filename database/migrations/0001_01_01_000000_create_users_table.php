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
        Schema::create('user', function (Blueprint $table) {
            $table->integer('id_user')->autoIncrement();
            $table->string('nama_user', 255);
            $table->string('no_hp', 15)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->string('password', 255);
            $table->string('role', 20)->default('user');
            $table->timestamps();
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->integer('id_admin')->autoIncrement();
            $table->string('nama_admin', 255);
            $table->string('username', 50)->nullable()->unique();
            $table->string('password', 255);
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
