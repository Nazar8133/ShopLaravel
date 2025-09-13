<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateBuyerRequest extends FormRequest
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
            'number'=>'required|unique:buyers,number,'.Auth::guard('buyers')->user()->idBuyer.',idBuyer|min:10|max:13|regex:/^(?:\+38)?0\d{9}$/u',
            'email'=>'required|unique:buyers,email,'.Auth::guard('buyers')->user()->idBuyer.',idBuyer|min:5|max:254|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'firstName'=>'required|min:2|max:83|regex:/^[А-ЯІЇЄҐ][а-яіїєґ\']+(?:-[а-яА-ЯіІїЇєЄґҐ\']+)?$/u',
            'lastName'=>'required|min:2|max:83|regex:/^[А-ЯІЇЄҐ][а-яіїєґ\']+$/u',
            'middleName'=>'required|min:2|max:83|regex:/^[А-ЯІЇЄҐ][а-яіїєґ\']+$/u'
        ];
    }

    public function messages(): array
    {
        return [
            'number.regex'=>'Введено непрвильний форма телефону!',
            'email.regex'=>'Введено не валідний формат електронної пошти!',
            'email.unique'=>'Аккаунт з такою поштою вже існує!',
            'firstName.regex'=>'Ім\'я повинно містити лише українські літери і починатись з великої літери!',
            'lastName.regex'=>'Прізвище повинно містити лише українські літери і починатись з великої літери!',
            'middleName.regex'=>'По батькові повинно містити лише українські літери і починатись з великої літери!',
            'number.unique'=>'Аккаунт з таким номером вже існує!',
        ];
    }
}
