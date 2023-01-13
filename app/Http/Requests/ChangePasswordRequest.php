<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'actual' => 'required',
            'nueva' => 'required|confirmed',
            'nueva_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'actual.required' => 'Por favor, ingresa tu contraseña actual',
            'nueva.required' => 'Debes ingresar una contraseña',
            'nueva.confirmed' => 'Las contraseñas ingresadas no coinciden',
            'nueva_confirmation.required' => 'Debe ingresar la confirmacion de la contraseña'
        ];
    }
}
