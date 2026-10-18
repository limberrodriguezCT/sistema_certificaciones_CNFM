<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Sistema de Certificados - CNFD')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .cnfd-bg { background-color: #0d47a1; } /* Azul oscuro */
        .cnfd-cyan { background-color: #00bcd4; } /* Cian */
        .cnfd-magenta { background-color: #e91e63; } /* Magenta */
        .cnfd-rounded { border-radius: 50%; border: 6px solid white; }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav class="cnfd-bg p-4 shadow-lg flex justify-between items-center text-white">
        <div class="font-bold text-xl tracking-wider">
            CNFD - Emisión de Certificados
        </div>
        <div>
            @auth
                <a href="{{ route('events.index') }}" class="mr-4 hover:text-gray-300">Eventos</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:text-gray-300">Cerrar Sesión</button>
                </form>
            @endauth
        </div>
    </nav>

    <main class="container mx-auto mt-8 p-4">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow" role="alert">
                <p class="font-bold">¡Excelente!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow" role="alert">
                <p class="font-bold">Aviso</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>