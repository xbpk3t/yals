<?php

namespace Modules\Common\Controllers;

use Modules\Common\Utils\Base\QiNiu;
use Modules\Common\Entities\UploadFile;
use Modules\Common\Requests\UploadFileRequest;

class UploadFileController extends BaseController
{
    protected $uploadFile;

    public function __construct(UploadFile $uploadFile)
    {
        $this->uploadFile = $uploadFile;
    }

    // 上传文件
    public function upload(UploadFileRequest $request)
    {
        $qiniu = new QiNiu();

        $files = $qiniu->saveFiles($request);

        $this->uploadFile->create($files);

        return $this->okList($files);
    }
}
