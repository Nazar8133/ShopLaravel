<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryAddressRequest extends FormRequest
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
            'region'=>'required|min:5|max:45|regex:/^[А-ЯІЇЄҐ][а-яіїєґ\']+(?:\s[а-яА-ЯІіЇїЄєҐґ\']+)?$/u',
            'city'=>'required|min:2|max:40|regex:/^[А-ЯІЇЄҐ][а-яіїєґ\']+(?:-[а-яА-ЯІіЇїЄєҐґ\']+)?(?:-[а-яА-ЯІіЇїЄєҐґ\']+)?$/u',
            'street'=>'required|min:2|max:45|regex:/^(?:[а-яА-ЯІіЇїЄєҐґ\']+\s)?[А-ЯІЇЄҐ][а-яіїєґ\']+(?:-[а-яА-ЯІіЇїЄєҐґ\']+)?(?:\s[а-яА-ЯІіЇїЄєҐґ\']+)?$/u',
            'houseNumber'=>'nullable|required_without:apartmentNumber|numeric|min:1|max:999',
            'apartmentNumber'=>'nullable|required_without:houseNumber|numeric|min:1|max:999'
        ];
    }

    public function messages(): array
    {
        return [
            'city.regex' => 'Введено невалідну назву міста!',
            'street.regex' => 'Введено невалідну назву вулиці!',
            'region.regex' => 'Введено невалідну назву області!',
            'houseNumber.required_without'=>'Одне з полів куди потрібно вводити номер повинно бути заповниним!',
            'apartmentNumber.required_without'=>'Одне з полів куди потрібно вводити номер повинно бути заповниним!'
        ];
    }
}
