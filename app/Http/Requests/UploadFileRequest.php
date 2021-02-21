<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
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
        switch ($this->hasFile('logo')) {
            case true :
                $rules = [
                    'logo'   => 'image|mimes:png,jpg,gif|max:512',
                ];
                break;
        }
        switch ($this->hasFile('attachment_name')) {
            case true :
                $rules = [
                    'attachment_name' => 'array',
                    'attachment_name.*' => 'required|mimes:jpeg,png,pdf|max:2048',
                ];
                break;
        }

        return $rules;
    }


    public function translateMessage(){
        $arrayMessage = array();

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
