<?php

namespace Modules\Common\Tests\Feature;

use Tests\TestCase;

//use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * @coversNothing
 */
class ApiTestCase extends TestCase
{
    // 使用迁移
    // 使用事务
//    use DatabaseTransactions;

    public $authHeader;
    public $params;
    public $data;
    public $user;
    protected $apiV1Url;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->apiV1Url = env('CURRENT_URL') . '/api/v1';
    }

    /**
     * ready for data & params.
     */
    protected function setUp(): void
    {
        // 每个test方法之前都会调用一次这个方法
        parent::setUp();
        $this->params = $this->readyApiParams();
        // 调用用户登录的操作
        $user = $this->userLogin($this->params['login']);
        $this->user = $user;
        // 获取用户 token
        $this->authHeader = $this->headers($user);

        // 刷新应用。该操作由TestCase的setup()方法自动调用，不然会使用过期的token
        $this->refreshApplication();
    }

    protected function userLogin(array $loginParam)
    {
        $response = $this->post($this->apiV1Url . '/user/login', $loginParam);
        $userInfo = $response->getOriginalContent();

        return $userInfo;
    }

    /**
     * Ready for test params.
     */
    protected function readyApiParams()
    {
        //这个方法用来放test里需要的参数
        $params = [];

        /** login params for test **/
        $login = [
            'mobile' => '18616287252',
            'code' => '9527',
            'device' => '23748237894',
        ];
        $params['login'] = $login;

        /** register user params for test **/
        $register = [
            'user_mobile' => '13777979098',
            'user_password' => 'a12345678',
            'confirm_password' => 'a12345678',
            'code' => '1234',
        ];
        $params['register'] = $register;

        $payPassword = ['pay_password' => 'b11111111'];
        $params['payPassword'] = $payPassword;

        return $params;
    }

    /**
     * Setting request header.
     *
     * @param array $addition
     *
     * @return array|string[]
     */
    protected function headers(array $user = [], $addition = [])
    {
        //添加版本号头部信息
        $headers = [
            'Accept' => 'application/prs.starter.v1.0+json',
            'plat' => 'ios',
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

    protected function assemblyGetUrl(string $url, $param = [])
    {
        return $url . '?' . http_build_query($param);
    }
}
