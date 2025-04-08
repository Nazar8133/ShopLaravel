<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrendRequest extends FormRequest
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
            'brend'=>'required|min:2|max:25|regex:/^[A-Za-z]+$/'
        ];
    }

    public function messages(): array
    {
        return [
            'brend.regex' => 'Назва бренду має містити лише латинські літери!',
        ];
    }
}
