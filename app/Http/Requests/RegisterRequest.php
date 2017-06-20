<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'                  => 'required|string|max:255',
            'surname'               => 'required|string|max:255',
            'nickname'              => 'required|string|max:255|unique:sportemu_users,nickname,NULL,id,deleted_at,NULL',
            'email'                 => 'required|max:255|email|unique:sportemu_users,email,NULL,id,deleted_at,NULL',
            'password'              => 'required|string|min:6|max:255|confirmed',
            'password_confirmation' => 'required',
            'agreement'             => 'required'
        ];
    }
}
