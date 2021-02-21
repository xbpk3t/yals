<?php

namespace Modules\Common\Controllers;

use Modules\Common\Entities\File;
use Modules\Common\Utils\Base\QiNiu;
use Modules\Common\Requests\File\DelRequest;
use Modules\Common\Requests\File\UploadRequest;
use Modules\Common\Requests\File\BatchDelRequest;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileController extends BaseController
{
    protected $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * 上传文件.
     */
    public function upload(UploadRequest $request): object
    {
        $qiniu = new QiNiu();

        $files = $qiniu->saveFiles($request);
        File::insert($files);

        return $this->okList($files);
    }

    public function del(DelRequest $request): object
    {
        try {
            File::query()->findOrFail($request->id)->delete();
        } catch (FileException $exception) {
            return $this->errorMsg($exception->getMessage());
        }

        return $this->okMsg();
    }

    /**
     * 批量删除文件.
     */
    public function batchDel(BatchDelRequest $request): object
    {
        try {
            File::query()->whereIn('id', $request->input('id', []))
                ->get()->each->delete();
        } catch (FileException $exception) {
            return $this->errorMsg($exception->getMessage());
        }

        return $this->okMsg();
    }
}
