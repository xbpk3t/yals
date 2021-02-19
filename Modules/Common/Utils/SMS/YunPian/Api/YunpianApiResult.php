<?php

namespace Modules\Common\Utils\SMS\YunPian\Api;

use Modules\Common\Utils\SMS\YunPian\Model\Result;
use Modules\Common\Utils\SMS\YunPian\Constant\Code;
use Modules\Common\Utils\SMS\YunPian\Constant\YunpianConstant;

interface YunpianApiResult
{
    /**
     * @return Result
     */
    public function result(array $rsp, ResultHandler $h, Result $r);

    /**
     * acquire response code.
     *
     * @param string $version
     *
     * @return number
     */
    public function code(array &$rsp, $version);
}
