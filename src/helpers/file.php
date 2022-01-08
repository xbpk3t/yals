<?php

/**
 * 用curl抓图片；会乱码；.
 * 用file_put_contents；只能在知道文件在项目里的路径的情况下，才能使用这个方法；
 * 需要用这个方法；.
 */
function getFileByUrl(string $url)
{
    //$des文件夹是目标文件夹的地址；
    $destination_folder = __DIR__ . '/images/';
    //存到本地文件名
    $newfname = $destination_folder . 'silicon valley-' . mt_rand(1, 33) . '.jpg'; //set your file ext
    $file = fopen($url, 'rb');

    if ($file) {
        $newf = fopen($newfname, 'a'); // to overwrite existing file
        if ($newf) {
            while (!feof($file)) {
                fwrite($newf, fread($file, 1024 * 8), 1024 * 8);
            }
        }
    }
    if ($file) {
        fclose($file);
    }
    if ($newf) {
        fclose($newf);
    }
}

/**
 * PHP读取Word文档；.
 *
 * @url https://stackoverflow.com/questions/10646445/read-word-document-in-php   ；并不需要PHPWORD，用这个方法可以直接取出字符串；
 *
 * @param $filename
 *
 * @return bool|string
 */
function getDocDetail($filename = '')
{
    $striped_content = '';
    $content = '';

    if (!$filename || !file_exists($filename)) {
        return false;
    }

    $zip = zip_open($filename);
    if (!$zip || is_numeric($zip)) {
        return false;
    }

    while ($zip_entry = zip_read($zip)) {
        if (false == zip_entry_open($zip, $zip_entry)) {
            continue;
        }
        if ('word/document.xml' != zip_entry_name($zip_entry)) {
            continue;
        }
        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
        zip_entry_close($zip_entry);
    }
    zip_close($zip);
    $content = str_replace('</w:r></w:p></w:tc><w:tc>', ' ', $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $striped_content = strip_tags($content);

    return $striped_content;
}
