<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StyleRequest extends FormRequest
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
            'style'=>'required|min:2|max:20|regex:/^[a-zA-Zа-яА-ЯёЁіІїЇєЄґҐʼ’\- ]+$/u'
        ];
    }

    public function messages(): array
    {
        return [
            'style.regex' => 'Назва стилю годинника повинна містити лише українські або англійські літери!',
        ];
    }
}
