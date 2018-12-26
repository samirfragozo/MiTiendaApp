<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'picture' => 'image|dimensions:min_width=400,min_height=400|max:1000',
            'document' => 'required|numeric|digits_between:6,12|unique:stores,document,' . $this->id,
            'name' => 'required|max:100',
            'address' => 'required|max:50',
            'neighborhood' => 'required|max:50',
            'phone' => 'nullable|numeric|digits_between:6,12',
            'cellphone' => 'required_without:phone|nullable|numeric|digits_between:6,12',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
            'provider' => 'nullable|boolean',
            'active' => 'nullable|boolean',
        ];
    }
}
