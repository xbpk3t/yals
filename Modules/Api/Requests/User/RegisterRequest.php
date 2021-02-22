<?php

namespace Modules\Api\Requests\User;

use Illuminate\Validation\Rule;
use Modules\Common\Requests\Base\ApiRequest;

class RegisterRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'code' => ['required', 'int'],
            'mobile' => ['required', 'string', Rule::unique('tz_user', 'mobile')],
            'password' => ['required', 'string'],
            'username' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'mobile.unique' => '用户已存在，请勿重复注册',
        ];
    }
}
