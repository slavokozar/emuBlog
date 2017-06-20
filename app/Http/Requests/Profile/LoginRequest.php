<?php

namespace App\Http\Requests\Profile;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        if (!Auth::attempt(['email' => Auth::user()->email, 'password' => $this->current_password])) {
            $validator->errors()->add('current_password', 'Your current password was wrong.');
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
        return [
            'current_password' => 'required|min:6',
            'password'         => 'required|min:6|confirmed',
        ];
    }
}
