<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class SubcontractorRequest extends FormRequest
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
                return $this->postRequest();
            }
            case 'PUT':
            case 'PATCH':
            {
                return $this->patchRequest();
            }
            default:break;
        }
        
    }

    public function postRequest(){
        $arrayRequest = array();
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $arrayRequest['name_'.$localeCode] = 'required|string|unique:subcontractors,name->'.$localeCode;
            $arrayRequest['address_'.$localeCode] = 'sometimes';
            $arrayRequest['bio_'.$localeCode] = 'sometimes';
        }
        $arrayRequest['email'] = 'sometimes|email|unique:subcontractors,email';
        $arrayRequest['phone'] = 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/|unique:subcontractors,phone';
        $arrayRequest['status'] = 'boolean';
        $arrayRequest['attachment_name'] = 'array';
        $arrayRequest['attachment_name.*'] = 'required|mimes:jpeg,png,pdf|max:2048';
        $arrayRequest['logo'] = 'image|mimes:png,jpg,gif|max:512';
        return $arrayRequest;
    }

    public function patchRequest(){
        $arrayRequest = array();
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $arrayRequest['name_'.$localeCode] = ['required','string', Rule::unique('subcontractors', 'name->'.$localeCode)->ignore($this->subcontractor)];
            $arrayRequest['address_'.$localeCode] = 'sometimes';
            $arrayRequest['bio_'.$localeCode] = 'sometimes';
        }
        $arrayRequest['email'] = ['sometimes','email', Rule::unique('subcontractors', 'email->'.$localeCode)->ignore($this->subcontractor)];
        $arrayRequest['phone'] = ['sometimes','regex:/^([0-9\s\-\+\(\)]*)$/', Rule::unique('subcontractors', 'phone->'.$localeCode)->ignore($this->subcontractor)];
        return $arrayRequest;
    }


    public function translateMessage(){
        $arrayMessage = array();
        foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties){
            $arrayMessage['name_'.$localeCode.'.required'] = __('validation.required', ['attribute'=> __('content.subcontractor name').' '.$localeCode]);
            $arrayMessage['name_'.$localeCode.'.string'] = __('validation.string',['attribute'=> __('content.subcontractor name').' '.$localeCode]);
            $arrayMessage['name_'.$localeCode.'.unique'] = __('validation.unique', ['attribute'=> __('content.subcontractor name').' '.$localeCode]);
        }
        $arrayMessage['status.boolean'] = __('validation.boolean', ['attribute'=> __('content.status')]);
        $arrayMessage['attachment_name.array'] = __('validation.array',['attribute'=>__('content.attachments')]);
        $arrayMessage['attachment_name.*.required'] = __('validation.required',['attribute'=>__('content.attachments')]);
        $arrayMessage['attachment_name.*.mimes'] = __('validation.mimes',['attribute'=>__('content.attachments')]);
        $arrayMessage['attachment_name.*.max'] = __('validation.max',['attribute'=>__('content.attachments')]);
        $arrayMessage['logo.image'] = __('validation.image',['attribute'=>__('content.subcontractor logo')]);
        $arrayMessage['logo.mimes'] = __('validation.mimes',['attribute'=>__('content.subcontractor logo')]);
        $arrayMessage['logo.max'] = __('validation.max',['attribute'=>__('content.subcontractor logo')]);
        return $arrayMessage;
    }

    public function messages()
    {
        return $this->translateMessage();
    }
}