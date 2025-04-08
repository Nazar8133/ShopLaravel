<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
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
