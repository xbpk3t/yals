<?php

namespace Modules\Common\Utils\Base;

use Qiniu\Etag;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use zgldh\QiniuStorage\QiniuStorage;

class QiNiu
{
    protected $client_ip = '127.0.0.1';
    protected $disk;

    public function __construct()
    {
        $this->disk = QiniuStorage::disk('qiniu');
    }

    /**
     * 单张图片上传.
     */
    public function saveFiles(Request $request): array
    {
        $files = $request->file();
        $category = $request->category;

        $files = array_map(function (UploadedFile $file) use ($category) {
            return $this->put($file, $category);
        }, $files);

        return $files;
    }

    private function put(UploadedFile $file, string $category)
    {
        $ext = $file->getClientOriginalExtension();
        $realPath = $file->getRealPath();
        $key = Etag::sum($realPath);

        $fileName = sprintf('%s.%s', $key[0], $ext);
        $contents = @file_get_contents($realPath);
        $result = $this->disk->put("$category/" . $fileName, $contents);

        if (!$result) {
            abort(400, '文件上传失败');
        }
        $md5 = md5_file($file->getRealPath());

        $download = $this->disk->downloadUrl("$category/" . $fileName);

        return [
            'filename' => $fileName,
            'ext' => $ext,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'md5' => $md5,
            'url' => $download->getUrl(),
            'category' => $category,
        ];
    }

//    public function uploads(Request $request)
//    {
//        $file = $request->file('file');
//        $this->client_ip = $request->ip();
//
//        if (!$file->isValid()) {
//            return ['status' => '400'];
//        }
//
//        if (isset($fileObject['path'])) {
//            $path = cdn($fileObject['path']);
//            return ['status' => '200', 'filename' => $path, 'url' => $path];
//        }
//
//        $fileObject = $this->put($file);
//        return ['status' => '200', 'filename' => $fileObject, 'url' => $fileObject];
//    }
//
//    public function remoteAllFiles($path = '/')
//    {
//        $disk = QiniuStorage::disk('qiniu');
//        $files = $disk->allFiles($path);
//        return $files;
//    }

//    /**
//     * @param $files
//     * @param $column
//     *
//     * @return array
//     */
//    public static function uploadImg($files, $column): array
//    {
//        // 未上传图片
//        if (!$files) {
//            return [];
//        }
//
//        // 单文件上传
//        if ($files instanceof \Illuminate\Http\UploadedFile) {
//            $filesArr[] = self::upload($column, $files);
//        }
//
//        // 多文件上传
//        foreach ($files as $file) {
//            $filesArr[] = self::upload($column, $file);
//        }
//
//        return $filesArr;
//    }
//
//    /**
//     * @param $file
//     * @param $column
//     *
//     * @return string
//     */
//    private static function upload($file, $column): string
//    {
//        $column = rand(1, 9999). '.jpg';
//        $disk = QiniuStorage::disk('qiniu');
//        $img = $disk->put($column, $file);
//
//        return $disk->downloadUrl($img)->getUrl();
//    }
}
