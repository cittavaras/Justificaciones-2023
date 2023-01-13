<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
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
            'asignatura' => 'required',
            'tipoInasistencia' => 'required',
            'motivo' => 'required',
            'subioArchivo' => 'required',
            'comentario' => 'required|min:30|max:500',
        ];
    }

    public function messages()
    {
        return [
            'asignatura.required' => 'Debes mencionar asignatura',
            'tipoInasistencia.required' => 'Debes marcar si faltaste a prueba o no',
            'motivo.required' => 'Debes indicar un motivo',
            'subioArchivo.required' => 'Debes adjuntar una imagen',
            'comentario.required' => 'El comentario es obligatorio',
            'comentario.min' => 'El largo mínimo del comentario es de :min caracteres',
            'comentario.max' => 'El largo máximo del comentario es de :max caracteres',
        ];
    }
}
