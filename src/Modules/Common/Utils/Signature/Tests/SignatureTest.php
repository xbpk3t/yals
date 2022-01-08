<?php

namespace Modules\Common\Utils\Signature\Tests;

use Tests\TestCase;
use Illuminate\Support\Str;

// api.signature中间件的单元测试
/**
 * @coversNothing
 */
class SignatureTest extends TestCase
{
    protected $nonceKey = 'api:nonce:';

    protected $signKeys = [
        'app_id',
        'timestamp',
        'nonce',
        'http_method',
        'http_path',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        \Route::middleware('api.signature')->get('/api/sign', function () {
            return 'OK';
        });
    }

    public function testClient()
    {
        $client = $this->clientService();
        $nonce = $client['nonce'];
        $timestamp = $client['timestamp'];
        $sign = $client['sign'];

        $isValid = $this->get("/api/sign?nonce=$nonce&timestamp=$timestamp&sign=$sign");

        $isValid->assertStatus(200);
    }

    public function clientService()
    {
        $nonce = $this->createNonce();
        $timestamp = time() - 100;
        $secret = config('api-custom.signature.secret');

        $signParams = [
            'nonce' => $nonce,
            'timestamp' => $timestamp,
            'http_method' => 'GET',
            'http_path' => '/api/sign',
        ];

        $sign = $this->sign($signParams, $secret);

        return ['nonce' => $nonce, 'timestamp' => $timestamp, 'sign' => $sign];
    }

    // 客户端生成sign
    public function sign(array $params, string $secret)
    {
        $params = array_filter($params, function ($value, $key) {
            return in_array($key, $this->signKeys);
        }, ARRAY_FILTER_USE_BOTH);

        ksort($params);

        return hash_hmac('sha256', http_build_query($params, null, '&'), $secret);
    }

    // 客户端生成nonce
    protected function createNonce()
    {
        return Str::orderedUuid()->toString();
    }
}
