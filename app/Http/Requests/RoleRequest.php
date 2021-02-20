<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RoleRequest extends FormRequest
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
                return $this->translateRequest();
            }
            case 'PUT':
            case 'PATCH':
            {
                return $this->translateRequestunique();
            }
            default:break;
        }
    }


    public function translateRequest(){
        $arrayRequest = array();
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $arrayRequest['name_'.$localeCode] = 'required|unique:roles,name->'.$localeCode;
        }
        $arrayRequest['permissions'] = 'required';
        return $arrayRequest;
    }

    public function translateRequestunique(){
        $arrayRequestunique = array();
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $arrayRequestunique['name_'.$localeCode] = ['required', Rule::unique('roles', 'name->'.$localeCode)->ignore($this->role)];
        }
        return $arrayRequestunique;
    }


    public function translateMessage(){
        $arrayMessage = array();
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $arrayMessage['name_'.$localeCode.'.required'] = __('validation.required', ['attribute'=> __('content.name',['model'=>trans_choice('content.role',1)]).' '.$localeCode]);
            $arrayMessage['name_'.$localeCode.'.unique'] = __('validation.unique', ['attribute'=> __('content.name',['model'=>trans_choice('content.role',1)]).' '.$localeCode]);
        }
        $arrayMessage['permissions.required'] = __('validation.required', ['attribute'=> __('content.permissions')]);
        return $arrayMessage;
    }

    public function messages()
    {
        return $this->translateMessage();
    }
}