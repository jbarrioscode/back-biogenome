<?php

namespace App\Http\Requests\TomaMuestrasInv\Muestra;

use Illuminate\Foundation\Http\FormRequest;

class MuestraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'paciente_id' => 'required',
            'protocolo_id' => 'required',
            'sedes_toma_muestras_id' => 'required',

        ];
    }
    public function messages(): array
    {
        return [
            'paciente_id.required' => 'El ID del paciente es requerido',
            'user_created_id.required' => 'El ID del usuario es requerido',
            'sedes_toma_muestras_id.unique' => 'El ID de la sede es requerido'
        ];
    }
}
