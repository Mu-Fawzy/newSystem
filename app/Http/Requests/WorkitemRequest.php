<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

class WorkitemRequest extends FormRequest
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
                    'name.*' => 'required|string|unique_translation:workitems',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name.*' => ['required','string', UniqueTranslationRule::for('workitems')->ignore($this->workitem)],
                ];
            }
            default:break;
        }
    }


    public function translateMessage(){
        $arrayMessage = array();
        foreach(LaravelLocalization::getSupportedLanguagesKeys() as $localeCode){
            $arrayMessage['name.'.$localeCode.'.required'] = __('validation.required', ['attribute'=> trans_choice('content.work item',1).' '.$localeCode]);
            $arrayMessage['name.'.$localeCode.'.string'] = __('validation.string', ['attribute'=> trans_choice('content.work item',1).' '.$localeCode]);
            $arrayMessage['name.'.$localeCode.'.unique_translation'] = __('validation.unique', ['attribute'=> trans_choice('content.work item',1).' '.$localeCode]);
        }
        return $arrayMessage;
    }

    public function messages()
    {
        return $this->translateMessage();
    }

}
