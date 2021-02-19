<?php

namespace Modules\Common\Utils\SMS\YunPian\Api;

use Modules\Common\Utils\SMS\YunPian\Model\Result;
use Modules\Common\Utils\SMS\YunPian\Constant\Code;
use Modules\Common\Utils\SMS\YunPian\Constant\YunpianConstant;

class CommonResultHandler implements ResultHandler
{
    private $data;

    public function __construct(callable $data)
    {
        $this->data = $data;
    }

    public function succ(int $code, array $rsp, bool $r)
    {
        if (null == $r) {
            $r = new Result();
        }

        return $r->code($code)->msg(array_key_exists(YunpianConstant::MSG, $rsp) ? $rsp[YunpianConstant::MSG] : null,
            true)->data(call_user_func($this->data, $rsp));
    }

    public function fail(int $code, array $rsp, bool $r)
    {
        if (null == $r) {
            $r = new Result();
        }

        return $r->code($code)->msg(array_key_exists(YunpianConstant::MSG, $rsp) ? $rsp[YunpianConstant::MSG] : null,
            true)->detail(array_key_exists(YunpianConstant::DETAIL, $rsp) ? $rsp[YunpianConstant::DETAIL] : null,
            true);
    }

    public function catchException(\Exception $e, bool $r)
    {
        if (null == $r) {
            $r = new Result();
        }

        return $r->code(Code::UNKNOWN_EXCEPTION)->exception($e, true);
    }
}
