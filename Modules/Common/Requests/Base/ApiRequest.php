<?php

namespace Modules\Common\Requests\Base;

use Illuminate\Http\Request;
use Dingo\Api\Exception\ResourceException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ApiRequest extends FormRequest
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

    protected function failedValidation(Validator $validator): void
    {
        if ($this->container['request'] instanceof Request) {
            throw new ResourceException($validator->errors()->first(), null);
        }

//        throw (new ValidationException($validator))
//            ->errorBag($this->errorBag)
//            ->redirectTo($this->getRedirectUrl());
    }
}
