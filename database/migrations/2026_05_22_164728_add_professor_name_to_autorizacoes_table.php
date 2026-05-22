<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('autorizacoes', function (Blueprint $table) {
            
            $table->string('professor_name')->nullable()->after('horario');
        });
    }

    public function down(): void
    {
        Schema::table('autorizacoes', function (Blueprint $table) {
            $table->dropColumn('professor_name');
        });
    }
};