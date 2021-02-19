<?php

namespace Modules\Common\Utils\SMS\YunPian\Api;

use Modules\Common\Utils\SMS\YunPian\Model\Result;
use Modules\Common\Utils\SMS\YunPian\YunpianClient;

/**
 * https://www.yunpian.com/api2.0/sign.html.
 *
 * @author dzh
 *
 * @since 1.0
 */
class SignApi extends YunpianApi
{
    const NAME = 'sign';

    public function init(YunpianClient $clnt)
    {
        parent::init($clnt);
//        $this->host($clnt->conf(self::YP_SIGN_HOST, 'https://sms.yunpian.com'));
        $this->host($clnt->conf(self::YP_SIGN_HOST));
    }

    public function name()
    {
        return self::NAME;
    }

    /**
     * 添加签名API
     * @param array $param
     * @return Result|null
     */
    public function add(array $param = [])
    {
        static $must = [self::APIKEY, self::SIGN];
        $r = $this->verifyParam($param, $must);
        if (!$r->isSucc()) {
            return $r;
        }
        $v = $this->version();
        $h = new CommonResultHandler(function ($rsp) use ($v) {
            switch ($v) {
                case self::VERSION_V2:
                    return $rsp[self::SIGN];
            }

            return null;
        });

        return $this->path('add.json')->post($param, $h, $r);
    }

    /**
     * 修改签名API
     *
     * @param array $param
     * @return Result|null
     */
    public function update(array $param)
    {
        static $must = [self::APIKEY, self::OLD_SIGN];
        $r = $this->verifyParam($param, $must);
        if (!$r->isSucc()) {
            return $r;
        }
        $v = $this->version();
        $h = new CommonResultHandler(function ($rsp) use ($v) {
            switch ($v) {
                case self::VERSION_V2:
                    return $rsp[self::SIGN];
            }

            return null;
        });

        return $this->path('update.json')->post($param, $h, $r);
    }

    /**
     * 获取签名API
     *
     * @param array $param
     * @return Result|null
     */
    public function get(array $param)
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
                    return $rsp[self::SIGN];
            }

            return null;
        });

        return $this->path('get.json')->post($param, $h, $r);
    }
}
