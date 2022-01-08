<?php

namespace Modules\Api\Tests\Feature;

use Modules\Common\Tests\Feature\BaseTestCase;

/**
 * @coversNothing
 */
class UserTest extends BaseTestCase
{
    public function testRegister()
    {
        $response = $this->withHeaders($this->header)->post($this->host . '/api/user/register', [
            'mobile' => '18616287252',
            'code' => '9527',
            'password' => '102gzg9RBiLnOnwHx',
        ]);

        $response->assertStatus(200);
    }

    public function testLogin()
    {
        $url = $this->host . '/api/user/login';
        $response = $this->withHeaders($this->header)->post($url, [
            'username' => '115fd8bb-d64e-47b2-89fa-21640927aeb2',
            'password' => '102gzg9RBiLnOnwHx',
        ]);

        $response->assertStatus(200);
    }

    public function testRefresh()
    {
        $url = $this->host . '/api/user/refresh';
        $response = $this->withHeaders($this->isLoginHeader())->post($url);

        $response->assertStatus(200);
    }

    public function testLogout()
    {
        $url = $this->host . '/api/user/logout';
        $response = $this->withHeaders($this->isLoginHeader())->post($url);

        $response->assertStatus(200);
    }
}
