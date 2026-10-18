<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreParticipantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $eventId = $this->route('event') ? $this->route('event')->id : $this->route('uuid');

        return [
            'full_name' => 'required|string|max:255',
            'cedula' => [
                'required',
                'string',
                'regex:/^[0-9]{3}-[0-9]{6}-[0-9]{4}[A-Z]$/i',
                Rule::unique('participants')->where(function ($query) use ($eventId) {
                    return $query->where('event_id', $eventId);
                })
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('participants')->where(function ($query) use ($eventId) {
                    return $query->where('event_id', $eventId);
                })
            ],
            'phone' => 'required|string|max:20',
            'location' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'El nombre completo es obligatorio.',
            'cedula.required' => 'El número de cédula es obligatorio.',
            'cedula.regex' => 'La cédula debe tener el formato válido (Ej. 000-000000-0000A).',
            'cedula.unique' => 'Este número de cédula ya se encuentra registrado en el evento actual.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un formato de correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya se encuentra registrado en el evento actual.',
            'phone.required' => 'El número de teléfono es obligatorio.',
            'location.required' => 'El lugar de procedencia es obligatorio.'
        ];
    }
}