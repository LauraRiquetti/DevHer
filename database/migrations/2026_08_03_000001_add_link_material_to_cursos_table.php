<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Adiciona a coluna "link_material" na tabela cursos
|--------------------------------------------------------------------------
| É uma migration só de ADIÇÃO — não toca nas colunas que já existem
| (nome, preco, descricao, imagem, categoria, user_id). Serve para guardar
| o link do vídeo/PDF/material do curso, usado nos cursos gratuitos para
| dar acesso direto ao conteúdo.
*/
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            if (!Schema::hasColumn('cursos', 'link_material')) {
                $table->string('link_material')->nullable()->after('imagem');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn('link_material');
        });
    }
};