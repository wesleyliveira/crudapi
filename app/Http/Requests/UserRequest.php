<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422));
    }

    public function rules(): array
    {
        #RECUPERA O ID ENVIADO NA URL
        $userId = $this->route('user');
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . ($userId ? $userId->id : null),
            'password' => 'required|min:6'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Campo nome obrigatório!',
            'email.required' => 'Campo e-mail obrigatório!',
            'email.email' => 'Necessário e-mail válido!',
            'email.unique' => 'E-mail cadastrado!',
            'password.required' => 'Campo senha obrigatório!',
            'password.min' => 'Senha minima :min caracteres!',
        ];
    }
}
