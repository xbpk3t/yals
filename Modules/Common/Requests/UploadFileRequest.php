<?php

namespace Modules\Common\Requests;

use Modules\Common\Requests\Base\ApiRequest;

class UploadFileRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => ['required', 'image', 'max:2000'],
            'category' => ['required', 'string'],
        ];
    }
}
