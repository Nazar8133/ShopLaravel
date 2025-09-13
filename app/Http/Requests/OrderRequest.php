<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderRequest extends FormRequest
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
            'selected_delivery'=>'required|in:nova_post,pickup,courier_delivery',
            'selected_payment'=>'required|in:cash,googlePay,liqPay',
            'koment'=>'nullable|string|min:5|max:500'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('selected_delivery') && $this->selected_delivery!='pickup'){
                $message='Неможливо оформити замовлення ';
                if ($this->selected_delivery=='nova_post' && Auth::guard('buyers')->user()->idNovaPost==null){
                    $message.='з доставкою від Нової Пошти, не вибравши відділення доставки!';
                    $validator->errors()->add('errorGuest', $message);
                }
                elseif ($this->selected_delivery=='courier_delivery' && Auth::guard('buyers')->user()->idAddress==null){
                    $message.='з доставкою від курєра, якщо немає адреси доставки!';
                    $validator->errors()->add('errorGuest', $message);
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'selected_delivery.in' => 'Такої доставки немає!',
            'selected_payment.in' => 'Такої оплати немає!',
            'selected_payment.required' => 'Виберіть спосіб оплати!',
            'selected_delivery.required' => 'Виберіть спосіб доставки!'
        ];
    }
}
