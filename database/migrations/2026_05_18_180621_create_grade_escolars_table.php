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
        Schema::create('grade_escolars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->comment('Professor');
            $table->foreignId('turmas_id')->constrained()->comment('Turma');
            $table->tinyInteger('day_of_week'); // 1 = Segunda, 2 = Terça...
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_escolars');
    }
};
