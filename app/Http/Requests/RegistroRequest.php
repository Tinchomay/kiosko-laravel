<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password as PasswordRules;

class RegistroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //Cambiamos a true para que tengamos acceso a ese request
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            //Confirmed es para que coincida con el password de confirmacion
            //Con esta clase tiene que tener letras, simbolos y numeros
            'password' => ['required', 'confirmed', PasswordRules::min(8)->letters()->symbols()->numbers()]
        ];
    }

    public function messages()
    {
        return [
            //Podemos acceder a los metodos de validacion para hacer mas especificos los mensajes
            'name.required' => 'El nombre es obligatorio',
            'name.string' => 'El formato del nombre es incorrecto',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El formato del email es incorrecto',
            'email.unique' => 'El email ya esta registrado',
            'password.required' => 'El password es obligatorio',
            'password.confirmed' => 'Los passwords ingresados no coinciden',
            'password' => 'El password tiene que contener minimo 8 caracteres, un simbolo y un numero'
        ];
    }
}
