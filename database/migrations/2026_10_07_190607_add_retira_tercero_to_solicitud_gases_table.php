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
        Schema::table('solicitud_gases', function (Blueprint $table) {
            $table->enum('retira_tercero', ['si','no']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitud_gases', function (Blueprint $table) {
            $table->dropColumn('retira_tercero');
        });
    }
};
