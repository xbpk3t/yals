<?php

namespace Modules\Common\Utils\ApiEncrypt\AES\Tests;

use Route;
use Illuminate\Http\Request;
use Modules\Api\Entities\User;
use Modules\Common\Traits\RestfulResponse;
use Modules\Common\Tests\Feature\BaseTestCase;
use Modules\Api\Transformers\User\UserTransformer;

/**
 * @coversNothing
 */
class AesTest extends BaseTestCase
{
    use RestfulResponse;

    protected $encryptUrl = '/user/encrypt';
    protected $decryptUrl = '/user/decrypt';

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware([
            'aes.encrypt',
        ])->post($this->encryptUrl, function (Request $request) {
            $users = User::query()->where('mobile', '18616287252')->first();

            return $this->response->item($users, new UserTransFormer());
        });

        Route::middleware([
            'aes.decrypt',
        ])->post($this->decryptUrl, function (Request $request) {
            return $request->all();
        });
    }

    public function testAesCollectionDecrypt()
    {
        $en = $this->getEncryptCtx();

        $response = $this->call('post', $this->decryptUrl, [], [], [],
            array_merge($this->header, ['CONTENT_TYPE' => 'application/json']),
            $en);

        $response->assertStatus(200);
        $this->assertEquals([
            'id' => 4,
            'username' => 'd729c0e7-e726-46c1-86f5-ccfd96c9acbf',
            'mobile' => '18616287252',
            'created_at' => '2021-02-22T16:08:49.000000Z',
            'updated_at' => '2021-02-22T16:08:49.000000Z',
        ], $response->getOriginalContent());
    }

    private function getEncryptCtx()
    {
        $response = $this->withHeaders($this->header)->json('post', $this->encryptUrl);

        return $response->getContent();
    }
}
