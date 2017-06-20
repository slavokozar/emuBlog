<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class CreateResortInfoRequest extends FormRequest
{
    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator|Validator
     */
    protected function getValidatorInstance()
    {
        $instance = parent::getValidatorInstance();

        $instance->after(function ($validator) {
            $this->doAdditionalValidation($validator);
        });

        return $instance;
    }

    /**
     * Compare dates of issuance and due dates.
     * Compare prices with and without VAT.
     *
     * @param $validator
     */
    private function doAdditionalValidation($validator)
    {
        if ($this->sameworkdays == 1) {
            if ($this->workdays != 1 && strtotime($this->open_workdays) > strtotime($this->close_workdays)) {
                $validator->errors()->add('close_later_workdays', 'Close time has to be after open time');
            }


            foreach (range(5, 7) as $i) {
                if ($this->{'closed'.$i} != 1 && strtotime($this->{'open_time'.$i}) > strtotime($this->{'close_time'.$i})) {
                    $validator->errors()->add('close_later'.$i, 'Close time has to be after open time');
                }
            }
        } else {
            foreach (range(1, 7) as $i) {
                if ($this->{'closed'.$i} != 1 && strtotime($this->{'open_time'.$i}) > strtotime($this->{'close_time'.$i})) {
                    $validator->errors()->add('close_later'.$i, 'Close time has to be after open time');
                }
            }
        }
    }

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
        $rules = [
            'name'              => 'required|string|max:255',
            'description'       => 'required|string',
            'address_street'    => 'required|string|max:255',
            'address_zip'       => 'required|numeric',
            'address_city'      => 'required|string|max:255',
            'address_state_id'  => 'required|exists:sportemu_states,id',
            'address_region_id' => 'required|exists:sportemu_regions,id',
            'address_county_id' => 'required|exists:sportemu_counties,id',
            'address_latitude'  => 'required|numeric',
            'address_longitude' => 'required|numeric',
        ];


        if ($this->sameworkdays == 1) {
            for ($i = 6; $i <= 7; $i++) {
                $rules[ 'open_time'.$i ] = 'required_or_closed:'.$i;
                $rules[ 'close_time'.$i ] = 'required_or_closed:'.$i;
            }
            $rules['open_workdays'] = 'required_or_closed';
            $rules['close_workdays'] = 'required_or_closed';
        } else {
            for ($i = 1; $i <= 7; $i++) {
                $rules[ 'open_time'.$i ] = 'required_or_closed:'.$i;
                $rules[ 'close_time'.$i ] = 'required_or_closed:'.$i;
            }
        }

        return $rules;
    }
}
