<?php

namespace Modules\Common\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Testing\TestResponse;

/**
 * @coversNothing
 */
class FileTest extends BaseTestCase
{
    // 上传文件
    public function testUpload()
    {
        $response = $this->upload();
        $ctx = $response->getOriginalContent();

        $response->assertStatus(200);
        $this->assertEquals('success', $ctx['message']);
    }

    // 单删图片
    public function testDel()
    {
        $url = $this->host . '/common/file/del';
        $response = $this->withHeaders($this->header)->delete($url, [
            'id' => $this->getFileId(),
        ]);
        $ctx = $response->getOriginalContent();

        $response->assertStatus(200);
        $this->assertEquals('success', $ctx['message']);
    }

    // 批量删除图片
    public function testBatchDel()
    {
        $url = $this->host . '/common/file/batchDel';
        $response = $this->withHeaders($this->header)->delete($url, [
            'id' => [$this->getFileId()],
        ]);
        $ctx = $response->getOriginalContent();

        $response->assertStatus(200);
        $this->assertEquals('success', $ctx['message']);
    }

    private function upload(): TestResponse
    {
        $url = $this->host . '/common/file/upload';
        $fakeImg = UploadedFile::fake()->image('test.jpg');

        $response = $this->withHeaders($this->header)->post($url, [
            'file' => $fakeImg,
            'category' => 'avatar',
        ]);

        return $response;
    }

    private function getFileId(): string
    {
        // 获取图片id
        $res = $this->upload();
        $ctxUpload = $res->getOriginalContent();
        $fileId = $ctxUpload['data']['file']['md5'];

        return $fileId;
    }
}
