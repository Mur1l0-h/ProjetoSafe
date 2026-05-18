<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Filament\Tables\Actions\Action;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('autorizacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estudantes_id')->constrained();
            $table->enum('type', ['entrada', 'saida']);
            $table->enum('status', ['pendente', 'concluida'])->default('pendente');
            $table->integer('absences_to_apply')->default(0);
            $table->foreignId('created_by')->constrained('users')->comment('Coordenador');
            $table->foreignId('validated_by')->nullable()->constrained('users')->comment('Porteiro');
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autorizacaos');
    }
};
