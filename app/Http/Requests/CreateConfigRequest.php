<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateConfigRequest extends FormRequest
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
        return [
            'name' => Rule::in(['SLACK_HOOK_URL', 'STORAGE_LOCATION']),
            'SLACK_HOOK_URLvalue' => 'regex:/^https\:\/\/hooks.slack.com\/services\/.*$/',
            'STORAGE_LOCATIONvalue' => 'directory'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.in' => 'Invalid Request',
            'SLACK_HOOK_URLvalue.regex' => 'Slack Hook url doesn\'t look right, please make sure you copied everything',
            'STORAGE_LOCATIONvalue.directory' => 'You need to enter a directory which exists'
        ];
    }
}
