<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BasketRequest extends FormRequest
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
        return [];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $i=0;
            foreach ($this->all() as $key => $value) {
                if (str_starts_with($key, 'kolvo')) {
                    if (!is_numeric($value)) {
                        $validator->errors()->add($key, 'Кількість повинна бути числом.');
                        return back()->withErrors($validator, 'errorKolvo');
                    }
                    if ($value>session('basket')[$i]['maxKolvo']){
                        $validator->errors()->add($key, 'Годинник '.session('basket')[$i]['name'].' можна купити в максимальній кількості '.session('basket')[$i]['maxKolvo'].' штук!');
                        return back()->withErrors($validator, 'errorKolvo');
                    }
                    if ($value<0){
                        $validator->errors()->add($key, 'Кількість годинника повинна бути більше 0.');
                        return back()->withErrors($validator, 'errorKolvo');
                    }
                    $i++;
                }
            }
        });
    }


}
