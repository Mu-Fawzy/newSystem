<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class WorkitemRequest extends FormRequest
{
    public function expectsJson()
    {
        return true;
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
            $arrayRequest['name.'.$localeCode] = "required|string|unique:workitems,name->$localeCode";
        }
        return $arrayRequest;
    }

    public function translateRequestunique(){
        $arrayRequestunique = array();
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $arrayRequestunique['name.'.$localeCode] = ['required','string', Rule::unique("workitems", "name->$localeCode")->ignore($this->workitem)];
        }
        return $arrayRequestunique;
    }


    public function translateMessage(){
        $arrayMessage = array();
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $arrayMessage['name.'.$localeCode.'.required'] = __('validation.required', ['attribute'=> trans_choice('content.work item',1).' '.$localeCode]);
            $arrayMessage['name.'.$localeCode.'.string'] = __('validation.string', ['attribute'=> trans_choice('content.work item',1).' '.$localeCode]);
            $arrayMessage['name.'.$localeCode.'.unique'] = __('validation.unique', ['attribute'=> trans_choice('content.work item',1).' '.$localeCode]);
        }
        return $arrayMessage;
    }

    public function messages()
    {
        return $this->translateMessage();
    }

}
