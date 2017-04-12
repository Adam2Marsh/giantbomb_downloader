<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigUpdateRequest extends FormRequest
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
//        dd($this->input('SLACK_HOOK_URL'));
        return [
            'SLACK_HOOK_URL' => 'regex:/^https\:\/\/hooks.slack.com\/services\/.*$/'
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
            'SLACK_HOOK_URL.regex' => 'Slack Hook url doesn\'t look right, please make sure you copied everything'
        ];
    }
}
