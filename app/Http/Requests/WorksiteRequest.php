<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class WorksiteRequest extends FormRequest
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
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $arrayRequest['name_'.$localeCode] = 'required|string|unique:worksites,name->'.$localeCode;
            $arrayRequest['owner_'.$localeCode] = 'sometimes|string';
        }
        return $arrayRequest;
    }

    public function translateRequestunique(){
        $arrayRequestunique = array();
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $arrayRequestunique['name_'.$localeCode] = ['required','string', Rule::unique('worksites', 'name->'.$localeCode)->ignore($this->worksite)];
            $arrayRequestunique['owner_'.$localeCode] = 'sometimes|string';
        }
        return $arrayRequestunique;
    }

    public function translateMessage(){
        $arrayMessage = array();
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $arrayMessage['name_'.$localeCode.'.required'] = __('validation.required', ['attribute'=> trans_choice('content.work site',1).' '.$localeCode]);
            $arrayMessage['name_'.$localeCode.'.string'] = __('validation.string', ['attribute'=> trans_choice('content.work site',1).' '.$localeCode]);
            $arrayMessage['name_'.$localeCode.'.unique'] = __('validation.unique', ['attribute'=> trans_choice('content.work site',1).' '.$localeCode]);
            $arrayMessage['owner_'.$localeCode.'.string'] = __('validation.string', ['attribute'=> trans_choice('content.owner',1).' '.$localeCode]);
        }
        return $arrayMessage;
    }

    public function messages()
    {
        return $this->translateMessage();
    }
}
