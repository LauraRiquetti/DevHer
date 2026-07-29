<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Configuração de codificação de caracteres para suportar acentuação -->
    <meta charset="UTF-8">
    <!-- Ajuste de viewport para garantir responsividade em dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título dinâmico da página; se não for fornecido por @section('title'), assume 'DevHer' como padrão -->
    <title>@yield('title', 'DevHer') — DevHer</title>

    <!-- Pré-conexão com os servidores do Google Fonts para otimizar o carregamento de fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Carregamento das famílias de fontes personalizadas (Bricolage Grotesque, Inter e IBM Plex Mono) -->
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,500;12..96,600;12..96,700;12..96,800&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap" rel="stylesheet">
    <!-- Link para o arquivo CSS principal da aplicação compilado publicamente -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Carregamento do pacote de ícones Bootstrap Icons via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Seção reservada para injeção de estilos adicionais específicos de views filhas -->
    @yield('styles')
</head>
<body>

    <!-- Inclui o componente Blade do menu de navegação superior (navbar) -->
    @include('Components.navbar')

    <!-- Elemento principal de conteúdo da página -->
    <main>
        <!-- Seção reservada para renderizar o conteúdo específico de cada página -->
        @yield('content')
    </main>

    <!-- Inclui o componente Blade do rodapé da página (footer) -->
    @include('Components.footer')

    <!-- Carregamento do arquivo JavaScript principal da aplicação -->
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Seção reservada para injeção de scripts adicionais específicos de views filhas -->
    @yield('scripts')
</body>
</html>