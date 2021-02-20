<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFilesRequest extends FormRequest
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
                if (request()->hasFile('contract')) {
                    return [
                        'contract'          => 'required|mimes:png,jpeg,jpg,pdf|max:2048',
                    ];
                }elseif(request()->hasFile('invoices')) {
                    return [
                        'invoices'          => 'array',
                        'invoices.*'        => 'mimes:png,jpeg,jpg,pdf|max:2048',
                    ];
                }
                
            }
            case 'PUT':
            case 'PATCH':
            {
                return [];
            }
            default:break;
        }
    }
}
