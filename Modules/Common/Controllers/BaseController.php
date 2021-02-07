<?php

namespace Modules\Common\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use Helpers;

    public $status;

    protected $forbid = 207;

    protected $ban = 204;

    /**
     * @return mixed
     */
    public function okStr(string $data = '', int $code = 200, string $message = 'success')
    {
        return $this->ok([]);
    }

    // 返回msg
    public function okMsg($msg)
    {
        return $this->ok([], 200, $msg);
    }

    // 返回data
    public function okData(array $data = null)
    {
        return $this->ok($data);
    }

    // 错误，返回msg
    public function errorMsg(string $msg)
    {
        return $this->error([], 400, $msg);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    private function ok(array $data = null, int $code = 200, string $message = 'success')
    {
        $res = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        return $this->response->array($res);
    }

    /**
     * 返回400.
     *
     * @param array $data
     *
     * @return mixed
     */
    private function error(array $data = null, int $code = 400, string $message = 'error')
    {
        $res = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        return $this->response->array($res);
    }
}
