<?php

namespace Modules\Api\Requests\User;

use Illuminate\Validation\Rule;
use Modules\Common\Requests\Base\ApiRequest;

class LoginRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => ['required', Rule::exists('tz_user', 'mobile')],
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'username.exists' => '手机号未注册',
        ];
    }
}
