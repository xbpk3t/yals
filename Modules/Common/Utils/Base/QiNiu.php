<?php

namespace Modules\Common\Utils\Base;

use zgldh\QiniuStorage\QiniuStorage;

class QiNiu
{
    // 图片单传
    public static function uploadImg($img)
    {
        $disk = QiniuStorage::disk('qiniu');
        $imgFile = $disk->put('file.jpg', $img);

        return $disk->downloadUrl($imgFile)->getUrl();
    }

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
