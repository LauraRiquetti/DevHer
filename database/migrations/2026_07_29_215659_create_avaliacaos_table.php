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
        Schema::create('avaliacaos', function (Blueprint $table) {
            $table->id();
            // Quem está fazendo a avaliação (Cliente / Usuário logado)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Quem está recebendo a avaliação (Vendedora / Criadora)
            $table->foreignId('vendedora_id')->constrained('vendedoras')->onDelete('cascade');
            
            $table->text('comentario');
            $table->integer('nota')->default(5); // Ex: nota de 1 a 5
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacaos');
    }
};
