<?php

namespace Modules\Common\Http\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use Helpers;

    public $status;

    protected $forbid = 207;

    protected $ban = 204;

    /**
     * @param array  $data
     * @param int    $code
     * @param string $message
     *
     * @return mixed
     */
    public function respondSuccess(array $data = null, int $code = 200, string $message = 'success')
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
     * @param string $message
     * @param array  $data
     * @param int    $code
     *
     * @return mixed
     */
    public function respondError(string $message, array $data = null, int $code = 400)
    {
        $res = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        return $this->response->array($res);
    }

    /**
     * @param string $data
     * @param int    $code
     * @param string $message
     *
     * @return mixed
     */
    public function respondStringSuccess(string $data = '', int $code = 200, string $message = 'success')
    {
        $res = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        return $this->response->array($res);
    }
}
