<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            "name" => "required|string",
            "address" => "required|string",
            "country" => "required|string",
            "state" => "required|string",
            "email" => "required|email",
            "ccn" => "required|string|max:20|min:16",
            "ccd" => "required|string|max:5|min:4",
            "ccv" => "required|string|max:3|min:3",
            "products" => "required"
        ];
    }
}
