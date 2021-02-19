<?php

namespace Modules\Common\Utils\SMS\YunPian\Api;

use Modules\Common\Utils\SMS\YunPian\Model\Result;
use Modules\Common\Utils\SMS\YunPian\YunpianClient;

/**
 * https://www.yunpian.com/api2.0/tpl.html.
 *
 * @author dzh
 *
 * @since 1.0
 */
class TplApi extends YunpianApi
{
    const NAME = 'tpl';

    public function init(YunpianClient $clnt)
    {
        parent::init($clnt);
//        $this->host($clnt->conf(self::YP_TPL_HOST, 'https://sms.yunpian.com'));
        $this->host($clnt->conf(self::YP_TPL_HOST));
    }

    public function name()
    {
        return self::NAME;
    }

    /**
     * 取默认模板
     * @param array $param
     * @return Result|null
     */
    public function get_default(array $param)
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

        return $this->path('get_default.json')->post($param, $h, $r);
    }

    /**
     * 取模板
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
                case self::VERSION_V1:
                    return $rsp[self::TEMPLATE];
                case self::VERSION_V2:
                    return $rsp;
            }

            return null;
        });

        return $this->path('get.json')->post($param, $h, $r);
    }

    /**
     * 添加模板
     * @param array $param
     * @return Result|null
     */
    public function add(array $param)
    {
        static $must = [self::APIKEY, self::TPL_CONTENT];
        $r = $this->verifyParam($param, $must);
        if (!$r->isSucc()) {
            return $r;
        }
        $v = $this->version();
        $h = new CommonResultHandler(function ($rsp) use ($v) {
            switch ($v) {
                case self::VERSION_V1:
                    return $rsp[self::TEMPLATE];
                case self::VERSION_V2:
                    return $rsp;
            }

            return null;
        });

        return $this->path('add.json')->post($param, $h, $r);
    }

    /**
     * 删除模板
     *
     * @param array $param
     * @return Result|null
     */
    public function del(array $param)
    {
        static $must = [self::APIKEY, self::TPL_ID];
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

        return $this->path('del.json')->post($param, $h, $r);
    }

    /**
     * 修改模板
     *
     * @param array $param
     * @return Result|null
     */
    public function update(array $param)
    {
        static $must = [self::APIKEY, self::TPL_ID, self::TPL_CONTENT];
        $r = $this->verifyParam($param, $must);
        if (!$r->isSucc()) {
            return $r;
        }
        $v = $this->version();

        $h = new CommonResultHandler(function ($rsp) use ($v) {
            switch ($v) {
                case self::VERSION_V1:
                    return $rsp[self::TEMPLATE];
                case self::VERSION_V2:
                    return array_key_exists(self::TEMPLATE, $rsp) ? $rsp[self::TEMPLATE] : $rsp;
            }

            return null;
        });

        return $this->path('update.json')->post($param, $h, $r);
    }
}
