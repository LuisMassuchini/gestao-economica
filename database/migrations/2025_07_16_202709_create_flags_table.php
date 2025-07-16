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
    Schema::create('flags', function (Blueprint $table) {
        $table->id();
        $table->string('name');

        // Chave Estrangeira para o Grupo Econômico
        $table->foreignId('economic_group_id') // Cria a coluna `economic_group_id`
              ->constrained('economic_groups')   // Adiciona a restrição de chave estrangeira
              ->onDelete('restrict');         // Impede que um grupo seja deletado se tiver bandeiras

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flags');
    }
};
