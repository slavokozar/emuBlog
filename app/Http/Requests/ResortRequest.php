<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResortRequest extends FormRequest
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

            'name' => 'required',
            'invoice_recipient' => 'required',
            'description' => 'required',
            'address_street' => 'required',
            'address_zip' => 'required',
            'address_city' => 'required',
            'address_country' => 'required',
            'address_latitude' => 'required',
            'address_longitude' => 'required',
            'agreement' => 'required'

        ];
    }

}
