<?php

namespace Modules\Api\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Common\Http\Requests\Base\ApiRequest;

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
            'password' => ['required']
        ];
    }
}
