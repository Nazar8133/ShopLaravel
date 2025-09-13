<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WatchRequest extends FormRequest
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
            'name'=>'required|min:4|max:75',
            'discription'=>'required|min:50|max:2500',
            'price'=>'required|numeric|min_digits:3|max_digits:7',
            'search'=>'numeric|min:1|max:999',
            'photo'   => 'array', // Поле має бути масивом
            'photo.*' => 'image|max:5120'  // Валідація для кожного файлу окремо
        ];
    }

    public function messages(): array
    {
        return [
            'photo.*' => 'Файл повинен бути фотографією, і кожен файл повинен важити менше 5 мб!',
        ];
    }
}
