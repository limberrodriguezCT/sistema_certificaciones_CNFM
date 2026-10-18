@extends('layouts.app')
@section('title', 'Diseño y Coordenadas')

@section('content')
<div class="max-w-6xl mx-auto flex flex-col md:flex-row gap-6">
    
    <div class="w-full md:w-1/3 bg-white p-6 rounded shadow-md border-t-8 border-cyan-500">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Ajustes Visuales</h2>
        
        <form action="{{ route('events.save_map', $event) }}" method="POST" id="design-form" novalidate>
            @csrf
            <input type="hidden" name="x_coord" value="0">
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Posición Vertical (Y):</label>
                <div class="flex items-center">
                    <input type="text" name="y_coord" id="y_coord" class="w-full px-3 py-2 border rounded focus:outline-none bg-gray-100 font-bold" value="{{ $event->y_coord ?? 100 }}" readonly>
                    <span class="ml-2 text-gray-500 font-bold">mm</span>
                </div>
                <p class="text-xs text-gray-500 mt-1">Haga clic sostenido sobre el cuadro de texto para moverlo.</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Tipografía:</label>
                <select name="font_family" id="font_family" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-cyan-500">
                    <option value="helvetica" {{ ($event->font_family ?? '') == 'helvetica' ? 'selected' : '' }}>Helvetica (Institucional)</option>
                    <option value="times" {{ ($event->font_family ?? '') == 'times' ? 'selected' : '' }}>Times New Roman</option>
                    <option value="courier" {{ ($event->font_family ?? '') == 'courier' ? 'selected' : '' }}>Courier</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Tamaño de Letra:</label>
                <input type="number" name="font_size" id="font_size" class="w-full px-3 py-2 border rounded focus:outline-none focus:border-cyan-500 font-bold" value="{{ $event->font_size ?? 24 }}" min="10" max="150">
                <p class="text-xs text-gray-500 mt-1">Escriba el número o ajuste desde la esquina roja en la imagen.</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Color del Texto:</label>
                <input type="color" name="text_color" id="text_color" class="w-full h-10 border rounded cursor-pointer" value="{{ $event->text_color ?? '#0d47a1' }}">
            </div>

            <button type="submit" class="w-full cnfd-bg text-white px-4 py-2 rounded shadow font-bold hover:bg-blue-800 transition mb-3">Guardar Diseño</button>
            <a href="{{ route('certificates.preview', $event) }}" class="block text-center cnfd-magenta text-white px-4 py-2 rounded shadow font-bold hover:bg-pink-700 transition">Descargar Prueba PDF</a>
        </form>
        
        <hr class="my-6">
        
        <h3 class="text-sm font-bold text-gray-700 mb-2">Controles de Visor</h3>
        <div class="flex gap-2">
            <button id="zoom-in" type="button" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 font-bold">+</button>
            <button id="zoom-out" type="button" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 font-bold">-</button>
            <button id="zoom-reset" type="button" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 text-sm font-bold">Centrar</button>
        </div>
    </div>

    <!-- Se aplica object-fill para obligar a la imagen web a comportarse igual que la del PDF -->
    <div class="w-full md:w-2/3 bg-gray-200 rounded shadow-inner p-4 overflow-auto border border-gray-300 flex justify-center items-start" style="height: 80vh;">
        
        <div class="relative inline-block transform origin-top shadow-xl transition-transform duration-200 bg-white" id="cert-container" style="width: 297mm; height: 210mm;">
            
            <img src="{{ asset('storage/' . $event->template_path) }}" class="w-full h-full object-fill pointer-events-none">

            <div id="drag-container" class="absolute flex justify-center w-full" style="top: {{ $event->y_coord ?? 100 }}mm; left: 0; cursor: ns-resize;">
                <div class="relative border-2 border-dashed border-blue-500 p-1 inline-block bg-white bg-opacity-20">
                    <span id="preview-text" class="font-bold tracking-wide pointer-events-none block" style="font-family: {{ $event->font_family ?? 'Arial' }}, sans-serif; font-size: {{ $event->font_size ?? 24 }}pt; color: {{ $event->text_color ?? '#0d47a1' }}; line-height: 1;">
                        NOMBRE DEL PROTAGONISTA
                    </span>
                    <div id="resize-handle" class="absolute bottom-[-8px] right-[-8px] w-4 h-4 bg-red-600 rounded-full cursor-se-resize shadow-md"></div>
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
    
    document.getElementById('zoom-in').addEventListener('click', () => { scale += 0.2; updateZoom(); });
    document.getElementById('zoom-out').addEventListener('click', () => { if(scale > 0.4) scale -= 0.2; updateZoom(); });
    document.getElementById('zoom-reset').addEventListener('click', () => { scale = 1; updateZoom(); });
    
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