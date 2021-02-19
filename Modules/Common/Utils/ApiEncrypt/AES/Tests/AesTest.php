<?php

namespace Modules\Common\Utils\ApiEncrypt\AES\Tests;

use Tests\TestCase;
use Illuminate\Http\Request;
use Modules\Common\Traits\RestfulResponse;

/**
 * @coversNothing
 */
class AesTest extends TestCase
{
    use RestfulResponse;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('app.key', 'base64:UPop+S4yrbflbANL517/z1TUHvisT3pXB1+K6W9V4No=');

        // todo unittest里中间件执行顺序不对
        \Route::middleware([
            'aes.decrypt',
            'aes.encrypt',
        ])->any('/api/sign', function (Request $request) {
            dump($request->all());

            return $this->okList(['username' => 'jf']);
        });
    }

    public function testAes()
    {
        $httpVerbs = ['get', 'post', 'put', 'delete', 'patch'];

        $cipher = $this->mockClient();

        foreach ($httpVerbs as $verb) {
            $response = $this->withMiddleware([
                'aes.decrypt',
                'aes.encrypt',
            ])->call($verb, '/api/sign', [], [], [], [
                'Accept' => 'application/prs.starter.v1.0+json',
            ], $cipher);

            $response->assertStatus(200);
        }
    }

    // 接收服务端返回的密串，解密，处理后将返回加密，再发送到服务端
    protected function mockClient()
    {
        $res = jsonEncode([
            'userInfo' => [
                'avatar' => 'https://kernel.taobao.org//2020/11/talking_of_atomic_operations/',
                'username' => 'jeffcott',
                'balance' => 8888.88,
            ],
            'activity' => [
                'AEP的驱动使用一个称为index block的结构来管理元数据',
                '写日志算是实现事务最通用的方式了，日志一般分为redo和undo两种日志，为了加快恢复速度，一般还会引入检查点(checkpoint)的概念。在文件系统和数据库的实现中，基本上都能看到事务的身影。',
            ],
            'isPermanent' => true,
        ]);

        $en = encrypt($res);

        return $en;
    }
}
