<?php

namespace App\Http\Requests;

use App\Models\Event;
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
        $uuid = $this->route('uuid');
        $event = Event::where('uuid', $uuid)->first();
        $eventId = $event ? $event->id : 0;

        return [
            'full_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('participants', 'full_name')->where(function ($query) use ($eventId) {
                    return $query->where('event_id', $eventId);
                })
            ],
            'cedula' => [
                'required',
                'string',
                'regex:/^[0-9]{3}-[0-9]{6}-[0-9]{4}[A-Za-z]$/',
                Rule::unique('participants', 'cedula')->where(function ($query) use ($eventId) {
                    return $query->where('event_id', $eventId);
                })
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('participants', 'email')->where(function ($query) use ($eventId) {
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
            'full_name.unique' => 'Este nombre ya se encuentra registrado en este evento.',
            'cedula.required' => 'El número de cédula es obligatorio.',
            'cedula.regex' => 'La cédula debe tener el formato válido (000-000000-0000A).',
            'cedula.unique' => 'Este número de cédula ya se encuentra registrado en este evento.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un formato de correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya se encuentra registrado en este evento.',
            'phone.required' => 'El número de teléfono es obligatorio.',
            'location.required' => 'El lugar de procedencia es obligatorio.'
        ];
    }
}