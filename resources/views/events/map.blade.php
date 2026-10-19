@extends('layouts.app')
@section('title', 'Diseño y Coordenadas')

@section('content')
<div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-6">
    
    <div class="w-full md:w-1/3 bg-white p-6 rounded-xl shadow-md border-t-8 border-cyan-500">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-extrabold text-slate-800">Ajustes del Certificado</h2>
            <a href="{{ route('events.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>
        
        <form action="{{ route('events.save_map', $event) }}" method="POST" id="design-form" novalidate>
            @csrf
            <input type="hidden" name="x_coord" value="0">
            
            <div class="mb-4">
                <label class="block text-slate-700 font-bold mb-1.5 text-sm">Posición Vertical (Eje Y):</label>
                <div class="flex items-center">
                    <input type="text" name="y_coord" id="y_coord" class="w-full px-3 py-2 border rounded-lg focus:outline-none bg-slate-100 font-bold text-blue-900" value="{{ $event->y_coord ?? 100 }}" readonly>
                    <span class="ml-2 text-slate-500 font-bold">mm</span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Arrastre el recuadro sobre la imagen para ubicar la altura.</p>
            </div>

            <div class="mb-4">
                <label class="block text-slate-700 font-bold mb-1.5 text-sm">Tipografía:</label>
                <select name="font_family" id="font_family" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-cyan-500 bg-white">
                    <option value="helvetica" {{ ($event->font_family ?? '') == 'helvetica' ? 'selected' : '' }}>Helvetica (Institucional)</option>
                    <option value="times" {{ ($event->font_family ?? '') == 'times' ? 'selected' : '' }}>Times New Roman</option>
                    <option value="courier" {{ ($event->font_family ?? '') == 'courier' ? 'selected' : '' }}>Courier</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-slate-700 font-bold mb-1.5 text-sm">Tamaño de Letra (pt):</label>
                <input type="number" name="font_size" id="font_size" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-cyan-500 font-bold" value="{{ $event->font_size ?? 24 }}" min="10" max="150">
                <p class="text-xs text-slate-500 mt-1">Escriba el valor o arrastre el círculo rojo en la esquina del nombre.</p>
            </div>

            <div class="mb-6">
                <label class="block text-slate-700 font-bold mb-1.5 text-sm">Color del Texto:</label>
                <input type="color" name="text_color" id="text_color" class="w-full h-10 border rounded-lg cursor-pointer" value="{{ $event->text_color ?? '#0d47a1' }}">
            </div>

            <button type="submit" class="w-full cnfd-bg text-white px-4 py-2.5 rounded-xl shadow font-bold hover:opacity-95 transition mb-3 flex justify-center items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Diseño
            </button>
            <a href="{{ route('certificates.preview', $event) }}" target="_blank" class="w-full cnfd-magenta text-white px-4 py-2.5 rounded-xl shadow font-bold hover:bg-pink-700 transition flex justify-center items-center gap-2">
                <i class="fa-solid fa-eye"></i> Previsualizar PDF en Vivo
            </a>
        </form>
        
        <hr class="my-6">
        
        <h3 class="text-xs uppercase font-bold text-slate-500 mb-2">Herramientas de Zoom</h3>
        <div class="flex gap-2">
            <button id="zoom-in" type="button" class="bg-slate-200 px-4 py-2 rounded-lg hover:bg-slate-300 font-bold"><i class="fa-solid fa-magnifying-glass-plus"></i></button>
            <button id="zoom-out" type="button" class="bg-slate-200 px-4 py-2 rounded-lg hover:bg-slate-300 font-bold"><i class="fa-solid fa-magnifying-glass-minus"></i></button>
            <button id="zoom-reset" type="button" class="bg-slate-200 px-4 py-2 rounded-lg hover:bg-slate-300 text-sm font-bold">Ajustar</button>
        </div>
    </div>

    <div class="w-full md:w-2/3 bg-slate-200 rounded-xl shadow-inner p-4 overflow-auto border border-slate-300 flex justify-center items-start" style="height: 80vh;">
        <div class="relative inline-block transform origin-top shadow-xl transition-transform duration-200 bg-white" id="cert-container" style="width: 297mm; height: 210mm;">
            <img src="{{ asset('storage/' . $event->template_path) }}" class="w-full h-full object-fill pointer-events-none">

            <div id="drag-container" class="absolute flex justify-center w-full" style="top: {{ $event->y_coord ?? 100 }}mm; left: 0; cursor: ns-resize;">
                <div class="relative border-2 border-dashed border-blue-600 p-1 inline-block bg-white/30">
                    <span id="preview-text" class="font-bold tracking-wide pointer-events-none block" style="font-family: {{ $event->font_family ?? 'Arial' }}, sans-serif; font-size: {{ $event->font_size ?? 24 }}pt; color: {{ $event->text_color ?? '#0d47a1' }}; line-height: 1;">
                        NOMBRE DEL PROTAGONISTA
                    </span>
                    <div id="resize-handle" class="absolute bottom-[-8px] right-[-8px] w-4 h-4 bg-rose-600 rounded-full cursor-se-resize shadow-md"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let scale = 1;
    const container = document.getElementById('cert-container');
    const dragContainer = document.getElementById('drag-container');
    const resizeHandle = document.getElementById('resize-handle');
    const previewText = document.getElementById('preview-text');
    const fontSizeInput = document.getElementById('font_size');
    const yCoordInput = document.getElementById('y_coord');
    
    document.getElementById('zoom-in').addEventListener('click', () => { scale += 0.15; updateZoom(); });
    document.getElementById('zoom-out').addEventListener('click', () => { if(scale > 0.35) scale -= 0.15; updateZoom(); });
    document.getElementById('zoom-reset').addEventListener('click', autoZoom);
    
    function updateZoom() { container.style.transform = `scale(${scale})`; }

    function autoZoom() {
        let parentWidth = container.parentElement.clientWidth - 40;
        let certWidth = container.clientWidth;
        if (parentWidth < certWidth) {
            scale = parentWidth / certWidth;
            updateZoom();
        }
    }
    window.onload = autoZoom;

    document.getElementById('text_color').addEventListener('input', function() { previewText.style.color = this.value; });
    document.getElementById('font_family').addEventListener('change', function() {
        let fonts = { 'helvetica': 'Arial, sans-serif', 'times': '"Times New Roman", serif', 'courier': '"Courier New", monospace' };
        previewText.style.fontFamily = fonts[this.value];
    });
    fontSizeInput.addEventListener('input', function() { previewText.style.fontSize = this.value + 'pt'; });

    let isDragging = false, isResizing = false;
    let startY, startTopMm, startX, startFontSize;

    dragContainer.addEventListener('mousedown', function(e) {
        if(e.target === resizeHandle) return; 
        isDragging = true;
        startY = e.clientY;
        startTopMm = parseFloat(yCoordInput.value) || 100;
        dragContainer.style.cursor = 'grabbing';
    });

    resizeHandle.addEventListener('mousedown', function(e) {
        e.stopPropagation();
        isResizing = true;
        startX = e.clientX;
        startFontSize = parseFloat(fontSizeInput.value) || 24;
    });

    document.addEventListener('mousemove', function(e) {
        if (isDragging) {
            let dy_px = (e.clientY - startY) / scale;
            let mm_per_px = 210 / container.clientHeight;
            let newTopMm = startTopMm + (dy_px * mm_per_px);

            if(newTopMm < 0) newTopMm = 0;
            if(newTopMm > 200) newTopMm = 200;

            dragContainer.style.top = newTopMm + 'mm';
            yCoordInput.value = newTopMm.toFixed(2);
        }

        if (isResizing) {
            let dx_px = (e.clientX - startX) / scale;
            let newFontSize = startFontSize + (dx_px * 0.5);

            if(newFontSize < 10) newFontSize = 10;
            if(newFontSize > 150) newFontSize = 150;

            fontSizeInput.value = Math.round(newFontSize);
            previewText.style.fontSize = Math.round(newFontSize) + 'pt';
        }
    });

    document.addEventListener('mouseup', function() {
        isDragging = false;
        isResizing = false;
        dragContainer.style.cursor = 'ns-resize';
    });
</script>
@endsection