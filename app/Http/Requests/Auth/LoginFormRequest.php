<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "document_number" => "required|string|max:20",
            "password" => "required|string|max:255",
            "profile_id"=>"required|in:2,3"
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors'      => $validator->errors()
        ],Response::HTTP_BAD_REQUEST));
    }

     /**
     * Modify attribute name fo the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function attributes(){
        return [
            'document_number' => 'documento',
            'password' => 'contraseña',
            'profile_id'=>'rol'
        ];
    }
}
