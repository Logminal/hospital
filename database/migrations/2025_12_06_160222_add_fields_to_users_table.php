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
            // Разделение имени на ФИО
            $table->string('surname')->nullable()->after('name');
            $table->string('firstname')->nullable()->after('surname');
            $table->string('patronymic')->nullable()->after('firstname');
            
            // Дополнительные поля согласно ТЗ
            $table->string('email')->nullable()->after('pole');
            $table->string('phone')->nullable()->after('email');
            $table->date('birth_date')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['surname', 'firstname', 'patronymic', 'email', 'phone', 'birth_date']);
        });
    }
};
