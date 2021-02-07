<?php

namespace Modules\Common\Http\Controllers;

use Modules\Common\Http\Requests\UploadFileRequest;
use Modules\Common\Utils\Base\QiNiu;

class UploadFileController extends BaseController
{
    public function upload(UploadFileRequest $request)
    {
        $res = QiNiu::uploadImg($request->file);
        dd($res);
    }
}
