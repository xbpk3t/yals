<?php

namespace Modules\Common\Requests\File;

use Modules\Common\Requests\Base\ApiRequest;

class UploadRequest extends ApiRequest
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
