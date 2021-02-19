<?php

namespace Modules\Common\Utils\SMS\YunPian\Api;

use Modules\Common\Utils\SMS\YunPian\Model\Result;
use Modules\Common\Utils\SMS\YunPian\YunpianClient;

/**
 * https://www.yunpian.com/api2.0/api-flow.html.
 *
 * @author dzh
 *
 * @since 1.0
 */
class FlowApi extends YunpianApi
{
    const NAME = 'flow';

    public function init(YunpianClient $clnt)
    {
        parent::init($clnt);
//        $this->host($clnt->conf(self::YP_FLOW_HOST, 'https://flow.yunpian.com'));
        $this->host($clnt->conf(self::YP_FLOW_HOST));
    }

    public function name()
    {
        return self::NAME;
    }

    /**
     * 查询流量包
     * @param array $param
     * @return Result|null
     */
    public function get_package(array $param = [])
    {
        static $must = [self::APIKEY];
        $r = $this->verifyParam($param, $must);
        if (!$r->isSucc()) {
            return $r;
        }
        $v = $this->version();
        $h = new CommonResultHandler(function ($rsp) use ($v) {
            switch ($v) {
                case self::VERSION_V1:
                    return $rsp[self::FLOW_PACKAGE];
                case self::VERSION_V2:
                    return $rsp;
            }

            return null;
        });

        return $this->path('get_package.json')->post($param, $h, $r);
    }

    /**
     * 充值流量
     * @param array $param
     * @return Result|null
     */
    public function recharge(array $param = [])
    {
        static $must = [self::APIKEY, self::MOBILE];
        $r = $this->verifyParam($param, $must);
        if (!$r->isSucc()) {
            return $r;
        }
        $v = $this->version();
        $h = new CommonResultHandler(function ($rsp) use ($v) {
            switch ($v) {
                case self::VERSION_V1:
                    return $rsp[self::RESULT];
                case self::VERSION_V2:
                    return $rsp;
            }

            return null;
        });

        return $this->path('recharge.json')->post($param, $h, $r);
    }

    /**
     * 获取状态报告
     * @param array $param
     * @return Result|null
     */
    public function pull_status(array $param = [])
    {
        static $must = [self::APIKEY];
        $r = $this->verifyParam($param, $must);
        if (!$r->isSucc()) {
            return $r;
        }
        $v = $this->version();
        $h = new CommonResultHandler(function ($rsp) use ($v) {
            switch ($v) {
                case self::VERSION_V1:
                    return $rsp[self::FLOW_STATUS];
                case self::VERSION_V2:
                    return $rsp;
            }

            return null;
        });

        return $this->path('pull_status.json')->post($param, $h, $r);
    }
}
