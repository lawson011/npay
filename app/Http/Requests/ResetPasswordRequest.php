<?php

namespace App\Http\Requests;

use App\Services\ResponseService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResetPasswordRequest extends FormRequest
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
            'username'=>'required|exists:customers,username',
            'token' => 'required|exists:otp_codes,token',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException((new ResponseService())->getErrorResource([
            "message" => $validator->getMessageBag()->first(),
            "field_errors" => $validator->errors()
        ]));
    }
}
