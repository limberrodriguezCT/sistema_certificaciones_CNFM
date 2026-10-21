<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Centro Nacional de Formación de Maestras y Maestros')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .cnfd-bg { background: linear-gradient(90deg, #0a357a 0%, #0d47a1 100%); }
        .cnfd-cyan { background-color: #00bcd4; }
        .cnfd-magenta { background-color: #e91e63; }
    </style>
</head>
<body class="bg-slate-100 font-sans leading-normal tracking-normal min-h-screen flex flex-col">
    <nav class="cnfd-bg px-6 py-3 shadow-lg text-white border-b-4 border-cyan-400">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <a href="{{ route('events.index') }}" class="flex items-center gap-4 hover:opacity-95 transition">
                <img src="{{ asset('images/logo-inatec-blanco.png') }}" alt="INATEC" class="h-12 w-auto object-contain" onerror="this.style.display='none'">
                <div class="border-l-2 border-cyan-400 pl-4">
                    <span class="block font-extrabold text-lg md:text-xl tracking-wide leading-tight">
                        Centro Nacional de Formación de Maestras y Maestros de la Educación Técnica y Formación Profesional Sede Centro Tecnológico Olof Palme, Estelí
                    </span>
                    <span class="block text-xs text-cyan-200 uppercase tracking-widest font-semibold">
                        Sistema de Emisión de Certificados
                    </span>
                </div>
            </a>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('events.index') }}" class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 font-semibold text-sm flex items-center gap-2 transition">
                        <i class="fa-solid fa-calendar-check text-cyan-300"></i> Eventos
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline m-0">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-lg bg-pink-600 hover:bg-pink-700 font-semibold text-sm flex items-center gap-2 shadow transition">
                            <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <main class="container mx-auto mt-8 px-4 pb-12 flex-grow">
        @yield('content')
    </main>

    <footer class="bg-slate-800 text-slate-400 text-xs text-center py-4 border-t border-slate-700">
        Centro Nacional de Formación de Maestras y Maestros de la Educación Técnica y Formación Profesional Sede Centro Técnologico Olof Palme, Estelí &copy; {{ date('Y') }}
    </footer>

    <script>
        @if(session('success'))
            Swal.fire({
                title: 'Proceso Exitoso',
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
                title: 'Verifique los datos',
                html: '<ul class="text-left font-semibold text-gray-700 space-y-1">@foreach($errors->all() as $error) <li><i class="fa-solid fa-circle-exclamation text-pink-600 mr-1"></i> {{ $error }}</li> @endforeach</ul>',
                icon: 'warning',
                confirmButtonColor: '#e91e63'
            });
        @endif

        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Eliminar evento?',
                    text: "Esta acción es irreversible. Se eliminará el evento, su plantilla gráfica y todos los participantes asociados.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e91e63',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Sí, eliminar permanentemente',
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