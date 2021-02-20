<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name'      => 'required',
                    'email'     => 'required|email|unique:users,email',
                    'password'  => 'required|same:confirm-password',
                    'roles'     => 'required|array'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'      => 'required',
                    'email'     => 'required|email',Rule::unique('users', 'email')->ignore($this->id),
                    'password'  => 'same:confirm-password',
                    'roles'     => 'required|array'
                ];
            }
            default:break;
        }
    }

    public function translateMessage(){
        $arrayMessage = array();
        $arrayMessage['roles.required'] = __('validation.required', ['attribute'=> trans_choice('content.role',2)]);
        return $arrayMessage;
    }

    public function messages()
    {
        return $this->translateMessage();
    }
}
