<?php

namespace Modules\Common\Utils\SMS\YunPian\Api;

use Modules\Common\Utils\SMS\YunPian\Model\Result;

interface ResultHandler
{
    /**
     * Invoked if code is 0.
     * @param int $code
     * @param array $rsp
     * @param bool $r
     * @return mixed
     */
    public function succ(int $code, array $rsp, bool $r);

    /**
     * @param int $code
     * @param array $rsp
     * @param bool $r
     * @return mixed
     */
    public function fail(int $code, array $rsp, bool $r);

    /**
     * @param \Exception $e
     * @param bool $r
     * @return mixed
     */
    public function catchException(\Exception $e, bool $r);
}
