<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'document_type' => 'required|in:certificacion,reconocimiento,participacion',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'template_path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Fijate que el título del evento es obligatorio, no lo dejés vacío.',
            'document_type.required' => 'Seleccioná el tipo de documento que vas a emitir.',
            'document_type.in' => 'El tipo de documento seleccionado no es válido.',
            'start_date.required' => 'Necesitamos saber cuándo inicia el evento.',
            'end_date.required' => 'La fecha de finalización es obligatoria.',
            'end_date.after' => 'Ideay, la fecha de cierre tiene que ser mayor a la fecha de inicio.',
            'template_path.mimes' => 'El diseño solo puede ser en formato PDF, JPG o PNG.',
            'template_path.max' => 'El archivo del diseño está muy pesado, probá con uno menor a 5MB.'
        ];
    }
}