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
            'template_path' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título del evento es obligatorio.',
            'document_type.required' => 'Debe seleccionar el tipo de documento.',
            'document_type.in' => 'El tipo de documento seleccionado no es válido.',
            'start_date.required' => 'La fecha de inicio es requerida.',
            'end_date.required' => 'La fecha de finalización es obligatoria.',
            'end_date.after' => 'La fecha de cierre debe ser posterior a la fecha de inicio.',
            'template_path.mimes' => 'El archivo del diseño debe estar en formato JPG o PNG.',
            'template_path.max' => 'El archivo del diseño no debe superar el límite de 5MB.'
        ];
    }
}