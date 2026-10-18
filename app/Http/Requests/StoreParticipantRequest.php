<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'location' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Por favor, ingresá tu nombre completo tal como querés que salga en el certificado.',
            'email.required' => 'El correo electrónico es obligatorio para poder enviarte la información.',
            'email.email' => 'Revisá bien tu correo, parece que el formato no es el correcto.',
            'phone.required' => 'Dejanos un número de teléfono para cualquier contacto.',
            'location.required' => 'No olvidés indicarnos tu lugar de procedencia.'
        ];
    }
}