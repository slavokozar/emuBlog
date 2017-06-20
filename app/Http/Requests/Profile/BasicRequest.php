<?php

namespace App\Http\Requests\Profile;

use Auth;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;

class BasicRequest extends FormRequest
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
        if ($this->email != Auth::user()->email && UserService::getByEmail($this->email) != null) {
            $validator->errors()->add('email', 'Email already registered in the system.');
        }
        if ($this->nickname != Auth::user()->nickname && UserService::getByNickname($this->nickname) != null) {
            $validator->errors()->add('nickname', 'Nickname already registered in the system.');
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
            'name'     => 'required|string|max:255',
            'surname'  => 'required|string|max:255',
            'nickname' => 'required|string|max:255',
            'email'    => 'required|email|string|max:255'
        ];
    }
}
