<?php

namespace Modules\Common\Http\Requests;

use Modules\Common\Http\Requests\Base\ApiRequest;

class SendSmsRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => ['required'],
        ];
    }
}
