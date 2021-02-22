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
    }

    public function testLogin()
    {
        $response = $this->withHeaders($this->header)->post($this->host . '/api/user/login', [
            'username' => '111', 'password' => '111',
        ]);

        $response->assertStatus(200);
    }

    public function testRefresh()
    {
        $this->assertTrue(true);
    }

    public function testLogout()
    {
        $this->assertTrue(true);
    }
}
