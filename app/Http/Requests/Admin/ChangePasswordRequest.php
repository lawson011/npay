<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class ChangePasswordRequest extends FormRequest
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
            'old_password'=>'required|min:6',
            'password'=>'required|min:6|confirmed',
            'password_confirmation'=>'required',
        ];
    }

    public function withValidator(Validator $validator)
{
    $validator->after(function ($validator){
     if(!Hash::check($this->old_password, Auth::user()->password)){
        $validator->errors()->add('old_password','Old account password does not match');
     }


    });
}
}
