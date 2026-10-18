<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Sistema de Certificados - CNFD')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .cnfd-bg { background-color: #0d47a1; }
        .cnfd-cyan { background-color: #00bcd4; }
        .cnfd-magenta { background-color: #e91e63; }
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
                <a href="{{ route('events.index') }}" class="mr-4 font-bold hover:text-cyan-300">Eventos</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="font-bold hover:text-cyan-300">Cerrar Sesión</button>
                </form>
            @endauth
        </div>
    </nav>

    <main class="container mx-auto mt-8 p-4">
        @yield('content')
    </main>

    <script>
        @if(session('success'))
            Swal.fire({
                title: '¡Excelente!',
                text: '{{ session("success") }}',
                icon: 'success',
                confirmButtonColor: '#0d47a1'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Aviso',
                text: '{{ session("error") }}',
                icon: 'error',
                confirmButtonColor: '#e91e63'
            });
        @endif

        @if($errors->any())
            Swal.fire({
                title: 'Aviso',
                html: '<ul class="text-left font-bold text-gray-700">@foreach($errors->all() as $error) <li>- {{ $error }}</li> @endforeach</ul>',
                icon: 'warning',
                confirmButtonColor: '#e91e63'
            });
        @endif

        // Confirmación global para eliminar
        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Esta acción es irreversible! Se eliminará el evento, su diseño y todos los protagonistas registrados en él.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e91e63',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, eliminar todo',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>