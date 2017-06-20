<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'resort_id'     => 'required',
            'field_id'      => 'required',
            'opened'        => 'required',
            'start'         => 'required',
            'end'           => 'required',
            'date'          => 'required',
            'price'         => 'required',
            'meet_info'     => 'required',
            'contact_phone' => 'required'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        \Session::put('resort_id',$this->resort_id);
        \Session::put('sport_id',$this->sport_id);
        parent::failedValidation($validator);
    }

    protected function getValidatorInstance()
    {
        $instance = parent::getValidatorInstance();

        $instance->after(function ($validator) {
            $this->doTimeValidation($validator);
        });

        return $instance;
    }


    /**
     * Compare dates of issuance and due dates.
     * Compare prices with and without VAT.
     *
     * @param $validator
     */
    private function doTimeValidation($validator)
    {
        $start = strtotime($this->get('start'));
        $end = strtotime($this->get('end'));


        if(round(abs($end - $start) / 60,2) < 30){
            $validator->errors()->add('end', 'Too short reservation!');
        }

    }
}
