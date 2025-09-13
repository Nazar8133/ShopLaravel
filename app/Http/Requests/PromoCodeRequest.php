<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromoCodeRequest extends FormRequest
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
            'codeAmount'=>'required|min:1|numeric',
            'discountValue'=>'required|min:1|max:100|numeric',
            'dateStart'=>'required|date|after_or_equal:today',
            'dateEnd'=>'required|date|after_or_equal:tomorrow'
        ];
    }

    public function messages(): array
    {
        return [
            'dateStart.after_or_equal'=>'Дата початку повинна бути або сьогоднішня або майбутня.',
            'dateEnd.after_or_equal'=>'Дата кінця повинна бути завтрашня або майбутня.'
        ];
    }
}
