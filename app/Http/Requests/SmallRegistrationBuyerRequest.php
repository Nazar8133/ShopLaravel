<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SmallRegistrationBuyerRequest extends FormRequest
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
            'emailReg'=>'required|unique:buyers,email|min:5|max:254|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'password'=>'required|confirmed|min:7|max:50|regex:/^(?=.*[A-Z])(?=.*[\W_]).+$/',
            'password_confirmation'=>'required'
        ];
    }

    public function messages(): array
    {
        return [
            'emailReg.regex'=>'Введено не валідний формат електронної пошти!',
            'emailReg.unique'=>'Аккаунт з такою поштою вже існує!',
            'password.regex'=>'Пароль повинен містити лише латинські літери, мати хоча б одну велику літеру, та один символ!',
            'password.confirmed'=>'Паролі повинні співпадати!'
        ];
    }
}
