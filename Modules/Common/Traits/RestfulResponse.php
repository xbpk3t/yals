<?php

namespace Modules\Common\Traits;

use Dingo\Api\Routing\Helpers;

trait RestfulResponse
{
    use Helpers;

    public $status;

    protected $forbid = 207;

    protected $ban = 204;

    // 返回msg
    public function okMsg($msg = 'success')
    {
        return $this->ok(200, $msg);
    }

    // 入参为关联数组，data返回{}
    public function okObject(object $data)
    {
        return $this->ok(200, 'success', $data);
    }

    // 入参为索引数组，data返回[]
    public function okList(array $data)
    {
        return $this->ok(200, 'success', $data);
    }

    // data返回字符串
    public function okString(string $data = '')
    {
        return $this->ok(200, 'success', $data);
    }

    // 错误，返回msg
    public function errorMsg(string $msg)
    {
        return $this->error(400, $msg);
    }

    protected function created($data = null, array $headers = [])
    {
        return $this->response->created();
    }

    protected function noContent(array $headers = [])
    {
        return $this->response->noContent();
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    private function ok(int $code = 200, string $message = 'success', $data = [], array $headers = [])
    {
//        if ($data instanceof JsonResource) {
//            return $data->response()->withHeaders($headers)->setStatusCode(200);
//        }
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
    private function error(int $code = 400, string $message = 'error', array $data = null)
    {
        $res = [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];

        return $this->response->array($res);
    }
}
