<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGalleryRequest extends FormRequest
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
            'images_ids.*'          => 'exists:sportemu_images,id',
            'images_descriptions.*' => 'nullable|string|max:255',
            'images_banner'         => 'exists:sportemu_images,id'
        ];
    }
}
