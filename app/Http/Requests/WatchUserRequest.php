<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WatchUserRequest extends FormRequest
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
            'sort' => [Rule::in(['name', 'price', 'type'])],
            'direction' => [Rule::in(['asc', 'desc'])],
            'priceMin'=>'nullable|numeric|min:1000|max:10000000',
            'priceMax'=>'nullable|numeric|min:1000|max:10000000',
            'search'=>'max:100',
            'mechanismFilter.*'=>'numeric|min:1|max:999',
            'brendFilter.*'=>'numeric|min:1|max:999',
            'styleFilter.*'=>'numeric|min:1|max:999',
            'genderFilter.*'=>['numeric', Rule::in(['1', '2'])]
        ];
    }

    public function messages(): array
    {
        return [
            'sort' => 'Таке сортування неможливе!',
            'direction' => 'Таке сортування неможливе!',
            'priceMin'=>'Таке сортування за мінімальною ціною неможливе!',
            'priceMax'=>'Таке сортування за максимальною ціною неможливе!',
            'search'=>'Пошуковий запит не повинен мати в собі більше ніж 100 символів!',
            'mechanismFilter'=>'Таке сортування за механізмом неможливе!',
            'brendFilter'=>'Таке сортування за брендом неможливе!',
            'styleFilter'=>'Таке сортування за стилем неможливе!',
            'genderFilter'=>'Таке сортування за статтю неможливе!'
        ];
    }
}
