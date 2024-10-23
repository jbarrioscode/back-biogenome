<?php

namespace App\Http\Requests\Admin\Permission;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => 'required|min:3|unique:permissions'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'El NOMBRE del permiso es requerido',
            'name.unique' => 'Ya existe un PERMISO con este nombre',
            'name.min' => 'El NOMBRE debe contener minimo 3 caracteres'
        ];
    }
}
