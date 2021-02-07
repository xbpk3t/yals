<?php

namespace Modules\Common\Controllers;

use Modules\Common\Requests\UploadFileRequest;
use Modules\Common\Utils\Base\QiNiu;

class UploadFileController extends BaseController
{
    public function upload(UploadFileRequest $request)
    {
        $res = QiNiu::uploadImg($request->file);
        dd($res);
    }
}
