<?php

namespace Modules\Common\Utils\SMS\YunPian\Api;

interface ResultHandler
{
    /**
     * Invoked if code is 0.
     *
     * @return mixed
     */
    public function succ(int $code, array $rsp, bool $r);

    /**
     * @return mixed
     */
    public function fail(int $code, array $rsp, bool $r);

    /**
     * @return mixed
     */
    public function catchException(\Exception $e, bool $r);
}
