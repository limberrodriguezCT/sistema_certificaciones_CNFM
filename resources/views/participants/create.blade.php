<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Registro - {{ $event->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .cnfd-bg { background: linear-gradient(90deg, #0a357a 0%, #0d47a1 100%); }
        .cnfd-cyan { background-color: #00bcd4; }
        .cnfd-magenta { background-color: #e91e63; }
    </style>
</head>
<body class="bg-slate-100 font-sans leading-normal tracking-normal flex flex-col min-h-screen">
    
    <nav class="cnfd-bg px-6 py-3 shadow-lg text-white border-b-4 border-cyan-400">
        <div class="container mx-auto flex items-center justify-center md:justify-start gap-4">
            <img src="{{ asset('images/logo-inatec-blanco.png') }}" alt="INATEC" class="h-12 w-auto object-contain" onerror="this.style.display='none'">
            <div class="border-l-2 border-cyan-400 pl-4">
                <span class="block font-extrabold text-base md:text-xl tracking-wide leading-tight">
                    Centro Nacional de Formación de Maestras y Maestros
                </span>
                <span class="block text-xs text-cyan-200 uppercase tracking-widest font-semibold">
                    Registro Oficial de Protagonistas
                </span>
            </div>
        </div>
    </nav>

    <main class="flex-grow container mx-auto p-4 flex items-center justify-center my-6">
        <div class="w-full max-w-lg">
            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-200">
                <div class="h-2.5 flex">
                    <div class="w-1/2 cnfd-magenta"></div>
                    <div class="w-1/2 cnfd-cyan"></div>
                </div>
                
                <div class="p-8">
                    <div class="mb-6 relative">
                        <span class="px-3 py-1 bg-blue-50 text-blue-800 rounded-full text-xs font-extrabold uppercase border border-blue-200">
                            {{ $event->document_type }}
                        </span>
                        <h2 class="text-2xl font-extrabold text-slate-800 mt-2">Registro en Línea</h2>
                        <p class="text-cyan-700 font-bold mt-1">{{ $event->title }}</p>
                    </div>

                    <form action="{{ route('participants.store', $event->uuid) }}" method="POST" novalidate>
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-slate-700 font-bold mb-1.5 text-sm">Nombre Completo</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:border-blue-600" placeholder="Ingrese su nombre exacto para el certificado">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-slate-700 font-bold mb-1.5 text-sm">Número de Cédula</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fa-solid fa-id-card"></i>
                                </span>
                                <input type="text" name="cedula" id="cedula_input" value="{{ old('cedula') }}" maxlength="16" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:border-blue-600 uppercase font-semibold tracking-wider" placeholder="000-000000-0000A">
                            </div>
                            <p class="text-xs text-slate-500 mt-1">Los guiones se agregan automáticamente al escribir.</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-slate-700 font-bold mb-1.5 text-sm">Correo Electrónico</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:border-blue-600" placeholder="ejemplo@correo.com">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-slate-700 font-bold mb-1.5 text-sm">Número de Teléfono</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fa-solid fa-phone"></i>
                                </span>
                                <input type="text" name="phone" id="phone_input" value="{{ old('phone') }}" maxlength="9" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:border-blue-600" placeholder="8888-8888">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-slate-700 font-bold mb-1.5 text-sm">Centro o Lugar de Procedencia</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                    <i class="fa-solid fa-location-dot"></i>
                                </span>
                                <input type="text" name="location" value="{{ old('location') }}" class="w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl focus:outline-none focus:border-blue-600" placeholder="Ej. Estelí">
                            </div>
                        </div>

                        <button type="submit" class="w-full cnfd-bg text-white px-4 py-3.5 rounded-xl shadow-md font-bold hover:opacity-95 transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i> Enviar Registro
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Formateo automático de Cédula Nicaragüense: 000-000000-0000A
        const cedulaInput = document.getElementById('cedula_input');
        cedulaInput.addEventListener('input', function (e) {
            let raw = e.target.value.replace(/[^0-9a-zA-Z]/g, '').toUpperCase();
            let numbersPart = raw.slice(0, 13).replace(/[^0-9]/g, '');
            let letterPart = raw.slice(13, 14).replace(/[^A-Z]/g, '');
            
            let formatted = '';
            if (numbersPart.length > 0) {
                formatted += numbersPart.substring(0, 3);
            }
            if (numbersPart.length > 3) {
                formatted += '-' + numbersPart.substring(3, 9);
            }
            if (numbersPart.length > 9) {
                formatted += '-' + numbersPart.substring(9, 13);
            }
            if (numbersPart.length === 13 && letterPart.length > 0) {
                formatted += letterPart;
            }
            e.target.value = formatted;
        });

        // Formateo automático de Teléfono: 8888-8888
        const phoneInput = document.getElementById('phone_input');
        phoneInput.addEventListener('input', function (e) {
            let digits = e.target.value.replace(/\D/g, '').slice(0, 8);
            if (digits.length > 4) {
                e.target.value = digits.slice(0, 4) + '-' + digits.slice(4);
            } else {
                e.target.value = digits;
            }
        });

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
                title: 'Verifique los datos',
                html: '<ul class="text-left font-semibold text-gray-700 space-y-1">@foreach($errors->all() as $error) <li><i class="fa-solid fa-circle-exclamation text-pink-600 mr-1"></i> {{ $error }}</li> @endforeach</ul>',
                icon: 'warning',
                confirmButtonColor: '#e91e63'
            });
        @endif
    </script>
</body>
</html>