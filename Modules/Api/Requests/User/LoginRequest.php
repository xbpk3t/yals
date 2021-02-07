<?php

namespace Modules\Api\Requests\User;

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
            'username' => ['required'],
            'password' => ['required'],
        ];
    }
}
