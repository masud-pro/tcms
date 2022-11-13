<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdministratorStoreRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name'            => ['required'],
            'email'           => ['required', 'string', 'email:rfc,dns,SpoofCheckValidation', 'max:255', 'unique:users'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
            "dob"             => ['required', 'date'],
            "gender"          => ['nullable', 'string'],
            "phone_no"        => ['nullable', 'string'],
            "address"         => ['nullable', 'string'],
            "bank_account_no" => ['nullable', 'numeric'],
            "nid"             => ['nullable', 'numeric'],

        ];
    }

    // /**
    //  * Get the error messages for the defined validation rules.
    //  *
    //  * @return array
    //  */
    // public function messages() {
    //     return [
    //         'title.required' => 'A title is required',
    //         'body.required'  => 'A message is required',
    //     ];
    // }
}