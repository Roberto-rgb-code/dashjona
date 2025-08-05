<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Science Laravel</title>

    {{-- Estilos compilados --}}
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
    <div class="container mx-auto py-4">
        {{-- Contenido principal --}}
        @yield('content')
    </div>

    {{-- Carga Chart.js desde CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Scripts compilados por Laravel Mix --}}
    <script src="{{ mix('js/app.js') }}"></script>

    {{-- Scripts adicionales de cada vista --}}
    @yield('scripts')
</body>
</html>
