<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|max:50',
            'price' => 'required|numeric',
            'description' => 'required|max:200',
            'category_id' => 'required|exists:categories,id',
            'store_id' => 'required|exists:stores,id',
            'active' => 'boolean',
        ];
    }
}
