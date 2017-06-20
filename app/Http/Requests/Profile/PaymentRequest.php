<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'address_city' => 'required|string|max:255',
            'state' => 'max:255',
            'country' => 'required',
            'ico' => 'max:20'
        ];
    }
}
