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
    Schema::create('units', function (Blueprint $table) {
        $table->id();
        $table->string('trading_name'); // Nome Fantasia
        $table->string('company_name'); // Razão Social
        $table->string('cnpj')->unique(); // CNPJ deve ser único

        // Chave Estrangeira para a Bandeira
        $table->foreignId('flag_id')
              ->constrained('flags')
              ->onDelete('restrict');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
