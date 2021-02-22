<?php

namespace Modules\Common\Tests\Feature;

/**
 * @coversNothing
 */
class SmsLogTest extends BaseTestCase
{
    public function testSMS()
    {
        $url = $this->host . '/common/sms';
        $response = $this->withHeaders($this->header)
            ->post($url, [
            'mobile' => '18616287252',
        ]);

        $response->assertStatus(200);
        $this->assertEquals([
            'code' => 200,
            'message' => '短信发送成功',
            'data' => [],
        ], $response->getOriginalContent());
    }
}
