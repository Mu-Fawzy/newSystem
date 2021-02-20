<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContractRequest extends FormRequest
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
                    'contract_number'   => 'required|unique:contracts,contract_number',
                    'subcontractor_id'  => 'required|numeric',
                    'workitem_id'       => 'required|numeric',
                    'worksite_id'       => 'required|numeric',
                    'contract'          => 'required|mimes:png,jpeg,jpg,pdf|max:2048',
                    'invoices'          => 'array',
                    'invoices.*'        => 'mimes:png,jpeg,jpg,pdf|max:2048',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'contract_number'   => 'required',Rule::unique('contracts','contract_number')->ignore($this->contract),
                    'workitem_id'       => 'required|numeric',
                    'worksite_id'       => 'required|numeric',
                ];
            }
            default:break;
        }
    }


    public function translateMessage(){
        $arrayMessage = array();

        $arrayMessage['contract_number.required'] = __('validation.required', ['attribute'=> __('content.contract number')]);
        $arrayMessage['contract_number.unique'] = __('validation.unique', ['attribute'=> __('content.contract number')]);
        //---------------------------------
        $arrayMessage['subcontractor_id.required'] = __('validation.required', ['attribute'=> trans_choice('content.subcontractor',1)]);
        $arrayMessage['subcontractor_id.numeric'] = __('validation.unique', ['attribute'=> trans_choice('content.subcontractor',1)]);
        //-----------------------------------------
        $arrayMessage['workitem_id.required'] = __('validation.required', ['attribute'=>trans_choice('content.work item',1)]);
        $arrayMessage['workitem_id.numeric'] = __('validation.unique', ['attribute'=> trans_choice('content.work item',1)]);
        //-----------------------------------------
        $arrayMessage['worksite_id.required'] = __('validation.required', ['attribute'=>trans_choice('content.work site',1)]);
        $arrayMessage['worksite_id.numeric'] = __('validation.unique', ['attribute'=> trans_choice('content.work site',1)]);
        //-----------------------------------------
        $arrayMessage['contract.required'] = __('validation.required', ['attribute'=>trans_choice('content.contract',1)]);
        $arrayMessage['contract.mimes'] = __('validation.mimes', ['attribute'=> trans_choice('content.contract',1)]);
        $arrayMessage['contract.max'] = __('validation.max', ['attribute'=> trans_choice('content.contract',1)]);
        //-----------------------------------------
        $arrayMessage['invoices.array'] = __('validation.array', ['attribute'=>trans_choice('content.invoice',1)]);
        //-----------------------------------------
        $arrayMessage['invoices.*.mimes'] = __('validation.mimes',['attribute'=>'']);
        $arrayMessage['invoices.*.max'] = __('validation.max',['attribute'=>'']);

        return $arrayMessage;
    }

    public function messages()
    {
        return $this->translateMessage();
    }
}
