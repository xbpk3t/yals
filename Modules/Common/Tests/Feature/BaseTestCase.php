<?php

namespace Modules\Common\Tests\Feature;

use Tests\TestCase;

/**
 * @coversNothing
 */
class BaseTestCase extends TestCase
{
    public $host;

    public $header;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->host = 'http://kit.test';
    }

    protected function setUp(): void
    {
        // 每个test方法之前都会调用一次这个方法
        parent::setUp();
        // 获取用户 token
        $this->header = $this->headers();
    }

    /**
     * @return string[]
     */
    protected function headers(array $user = [], array $addition = []): array
    {
        //添加版本号头部信息
        $headers = [
            'Accept' => 'application/prs.starter.v1.0+json',
        ];
        //拼接 token
        if ($user) {
            $headers['Authorization'] = 'Bearer ' . $user['data']['token'];
        }

        if ($addition) {
            $headers = array_merge($headers, $addition);
        }

        return $headers;
    }
}
