<?php

namespace Database\Seeders;

use App\Models\Comunidade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ComunidadeSeeder extends Seeder
{
    public function run(): void
    {
        // Mesmos nomes que já aparecem na seção "Redes e iniciativas" da home
        $comunidades = [
            ['nome' => 'PyLadies', 'descricao' => 'Comunidade internacional de mulheres que programam em Python.'],
            ['nome' => 'Women Techmakers', 'descricao' => 'Iniciativa do Google para visibilidade e crescimento de mulheres em tech.'],
            ['nome' => 'Meninas Digitais', 'descricao' => 'Projeto que incentiva meninas a seguirem carreira em computação.'],
            ['nome' => 'ProgramAdas', 'descricao' => 'Rede que empodera mulheres através da tecnologia, diminuindo o gap de gênero no mercado.'],
            ['nome' => 'Rails Girls', 'descricao' => 'Workshops gratuitos que ensinam programação com Ruby on Rails para mulheres.'],
            ['nome' => 'Marias da Tech', 'descricao' => 'Comunidade brasileira de troca e apoio entre mulheres da tecnologia.'],
        ];

        foreach ($comunidades as $comunidade) {
            Comunidade::firstOrCreate(
                ['slug' => Str::slug($comunidade['nome'])],
                ['nome' => $comunidade['nome'], 'descricao' => $comunidade['descricao']]
            );
        }
    }
}