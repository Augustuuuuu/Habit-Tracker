<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:60|confirmed',
        ];
    }
    public function messages(): array
    {
        return array(
            'name.required' => 'O campo nome é obrigatório.',
            'name.max' => 'O campo deve ter no máximo 255 caracteres.',
            'name.string' => 'O nome deve ser um texto válido.',

            'email.required' => 'Campo de e-mail obrigatório.',
            'email.max' => 'O campo deve ter no máximo 255 caracteres.',
            'email.email' => 'O campo de e-mail deve ser um e-mail válido',
            'email.unique' => 'O e-mail já está em uso.',
            'email.string' => 'O e-mail deve ser um texto válido.',

            'password.required' => 'Campo de senha obrigatório.',
            'password.max' => 'A senha deve ter no máximo 60 caracteres.',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
            'password.string' => 'A senha deve ser um texto válido.',
        );

    }
}
