<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class SaveUserDataFromStepOne extends FormRequest
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
        $rules = [];
        if (Auth::user() && Auth::user()->temp_email) {
            $rules['email'] = 'required|string|email|max:255|unique:users';
        }

        return array_merge($rules, [
            'nickname' => 'required|filled|string|max:255',
            'name'     => 'required|filled|string|max:255',
            'surname'  => 'required|filled|string|max:255',
            /*'pseudonym' => 'required|filled|string|max:255',*/
            /*'nickname' => 'required|filled|string|max:255',*/
        ]);
    }
}
