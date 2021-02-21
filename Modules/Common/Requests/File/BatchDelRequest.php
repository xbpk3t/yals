<?php


namespace Modules\Common\Requests\File;


use Modules\Common\Requests\Base\ApiRequest;

class BatchDelRequest extends ApiRequest
{
    public function rules()
    {
        return [
            'id' => ['required', 'array']
        ];
    }

    public function messages()
    {
        return [
            'id.array' => '图片参数错误'
        ];
    }
}
