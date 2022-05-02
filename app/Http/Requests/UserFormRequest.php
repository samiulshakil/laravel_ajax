<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserFormRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'=>false,
                'errors'=> $validator->errors()
            ],200)
        );
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'role_id' => 'required', 'integer',
            'name' => 'required', 'string',
            'email' => 'required', 'email', 'unique:users,email',
            'avatar' => 'nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp',
            'district_id' => 'required', 'integer',
            'upazila_id' => 'required', 'integer',
            'address' => 'required', 'string',
            'password' => 'required|confirmed|string|min:8',
        ];
    }
}
