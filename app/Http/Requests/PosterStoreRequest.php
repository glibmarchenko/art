<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class PosterStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'required|string|max:255',
            /*'image_preview'   => 'required|image|dimensions:min_width=100, max_width=1920, min_height=100, max_height=1920',*/
            'image_preview'   => 'image|max:50000000000',
            /*'image_source'   => 'required',*/
            'price'   => 'required|integer',
            'width'   => 'required|integer',
            'height'   => 'required|integer',
            'year'   => 'required|integer',
            /*'description'   => 'required|string|max:255',*/
        ];
    }
}
