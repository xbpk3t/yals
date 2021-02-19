<?php

namespace Modules\Common\Utils\SMS\YunPian\Api;

use Modules\Common\Utils\SMS\YunPian\Model\Result;
use Modules\Common\Utils\SMS\YunPian\YunpianClient;

/**
 * https://www.yunpian.com/api2.0/user.html.
 *
 * @author dzh
 *
 * @since 1.0
 */
class UserApi extends YunpianApi
{
    const NAME = 'user';

    public function init(YunpianClient $clnt)
    {
        parent::init($clnt);
//        $this->host($clnt->conf(self::YP_USER_HOST, 'https://sms.yunpian.com'));
        $this->host($clnt->conf(self::YP_USER_HOST));
    }

    public function name()
    {
        return self::NAME;
    }

    /**
     * 查账户信息.
     *
     * @param array $param
     *
     * @return Result|null
     */
    public function get($param = [])
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
                    return $rsp[self::USER];
                case self::VERSION_V2:
                    return $rsp;
            }

            return null;
        });

        return $this->path('get.json')->post($param, $h, $r);
    }

    /**
     * 修改账户信息.
     *
     * @return Result|null
     */
    public function set(array $param = [])
    {
        static $must = [self::APIKEY];
        $r = $this->verifyParam($param, $must);
        if (!$r->isSucc()) {
            return $r;
        }
        $v = $this->version();
        $h = new CommonResultHandler(function ($rsp) use ($v) {
            switch ($v) {
                case self::VERSION_V2:
                    return $rsp;
            }

            return null;
        });

        return $this->path('set.json')->post($param, $h, $r);
    }
}
