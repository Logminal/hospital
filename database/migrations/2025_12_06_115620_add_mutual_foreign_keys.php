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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('doctor_id')
                ->references('id')
                ->on('doctors')
                ->onDelete('set null');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Удаляем ключ из doctors
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        // Удаляем ключ из users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
        });
    }
};
