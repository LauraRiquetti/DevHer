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
        Schema::create('topicos', function (Blueprint $table) {
            $table->id();
            // A qual comunidade (PyLadies, Women Techmakers...) esse tópico pertence
            $table->foreignId('comunidade_id')->constrained()->onDelete('cascade');
            // Quem abriu o tópico
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titulo');
            $table->text('mensagem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topicos');
    }
};