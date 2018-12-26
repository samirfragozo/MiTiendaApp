<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:50'],
            'neighborhood' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'numeric', 'digits_between:6,12'],
            'cellphone' => ['required_without:phone', 'nullable', 'numeric', 'digits_between:6,12'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->id],
        ];
    }
}
