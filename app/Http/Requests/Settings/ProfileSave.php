<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class ProfileSave extends FormRequest
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
            'name'      => 'required|filled|string|max:255',
            'surname'   => 'required|filled|string|max:255',
            'pseudonym' => 'max:255',
            'nickname'  => 'required|filled|string|max:255',
        ];
    }
}
