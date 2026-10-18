<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Registro - {{ $event->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .cnfd-bg { background-color: #0d47a1; }
        .cnfd-cyan { background-color: #00bcd4; }
        .cnfd-magenta { background-color: #e91e63; }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal flex flex-col min-h-screen">
    
    <nav class="cnfd-bg p-4 shadow-lg text-white">
        <div class="container mx-auto font-bold text-xl tracking-wider text-center md:text-left">
            CNFD - Emisión de Certificados
        </div>
    </nav>

    <main class="flex-grow container mx-auto p-4 flex items-center justify-center">
        <div class="w-full max-w-lg">
            
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="h-2 flex">
                    <div class="w-1/2 cnfd-magenta"></div>
                    <div class="w-1/2 cnfd-cyan"></div>
                </div>
                
                <div class="p-8">
                    <div class="mb-6 relative">
                        <h2 class="text-2xl font-bold text-gray-800">Registro en Línea</h2>
                        <p class="text-gray-600 font-bold mt-1">{{ $event->title }}</p>
                        <div class="absolute -top-4 -right-12 w-24 h-24 cnfd-cyan rounded-full opacity-20"></div>
                    </div>

                    <form action="{{ route('participants.store', $event->uuid) }}" method="POST" novalidate>
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Nombre Completo</label>
                            <input type="text" name="full_name" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" placeholder="Ingrese su nombre exacto para el certificado">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Número de Cédula</label>
                            <input type="text" name="cedula" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500 uppercase" placeholder="Ej. 000-000000-0000A">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Correo Electrónico</label>
                            <input type="email" name="email" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" placeholder="ejemplo@correo.com">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Número de Teléfono</label>
                            <input type="text" name="phone" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" placeholder="Ej. 8888-8888">
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 font-bold mb-2">Lugar de Procedencia</label>
                            <input type="text" name="location" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500" placeholder="Ej. Estelí">
                        </div>

                        <button type="submit" class="w-full cnfd-bg text-white px-4 py-3 rounded-full shadow-md font-bold hover:bg-blue-800 transition">Enviar Registro</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        @if(session('success'))
            Swal.fire({
                title: '¡Registro Exitoso!',
                text: '{{ session("success") }}',
                icon: 'success',
                confirmButtonColor: '#0d47a1'
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
    </script>
</body>
</html>