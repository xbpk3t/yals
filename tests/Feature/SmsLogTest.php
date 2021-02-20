<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * @coversNothing
 */
class SmsLogTest extends TestCase
{
    public $host;

//    public function __construct(?string $name = null, array $data = [], string $dataName = '')
//    {
//        parent::__construct($name, $data, $dataName);
//        $this->host = 'http://kit.test';
//    }

    public function testSMS()
    {
        $url = 'http://kit.test/common/sms';
//        $response = $this->withHeaders([
//            'Accept' => 'application/prs.starter.v1.0+json',
//        ])->post($url, [
//            'mobile' => '18616287252'
//        ]);

        $response = $this->call('POST', $url, [
            'mobile' => '18616287252',
        ], [], [], [
            'HTTP_Accept' => 'application/prs.starter.v1.0+json',
        ]);

        dd($response);

        $response->assertStatus(200);
    }
}
