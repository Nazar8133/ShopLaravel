<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MechanismRequest extends FormRequest
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
            'type'=>'required|min:2|max:25|regex:/^[a-zA-Zа-яА-ЯІіЇїЄєҐґʼ’\- ]+$/u'
        ];
    }

    public function messages(): array
    {
        return [
            'type.regex' => 'Назва типу годинника повинна містити лише українські або англійські літери!',
        ];
    }
}
