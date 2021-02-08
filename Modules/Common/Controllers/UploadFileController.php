<?php

namespace Modules\Common\Controllers;

use Modules\Common\Utils\Base\QiNiu;
use Modules\Common\Requests\UploadFileRequest;

class UploadFileController extends BaseController
{
    public function upload(UploadFileRequest $request)
    {
        $res = QiNiu::uploadImg($request->file);
        dd($res);
    }
}
