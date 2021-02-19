<?php

namespace Modules\Common\Utils\SMS\YunPian\Api;

use Modules\Common\Utils\SMS\YunPian\YunpianClient;

/**
 * 视频短信
 *
 * @author dzh
 *
 * @since 1.0.2
 */
class VideoSmsApi extends YunpianApi
{
    const NAME = 'vsms';

    public function init(YunpianClient $clnt)
    {
        parent::init($clnt);
//        $this->host($clnt->conf(self::YP_VSMS_HOST, 'https://vsms.yunpian.com'));
        $this->host($clnt->conf(self::YP_VSMS_HOST));
    }

    public function name()
    {
        return self::NAME;
    }

    /**
     * @param array $param
     *
     * @return \Modules\Common\Utils\SMS\YunPian\Model\Result|null
     */
    public function addTpl($param = [])
    {
        static $must = [self::APIKEY, self::SIGN, self::LAYOUT, self::MATERIAL];
        $r = $this->verifyParam($param, $must);
        if (!$r->isSucc()) {
            return $r;
        }
        $charset = $this->charset();
        $multipart = [];

        foreach ($param as $key => $value) {
            if (self::LAYOUT == $key) {
                $multipart[] = [
                    'name' => $key,
                    'contents' => $value,
                    'headers' => ['Content-Type' => "application/json;charset=$charset"],
                ];
            } elseif (self::MATERIAL == $key) {
                $multipart[] = [
                    'name' => $key,
                    'contents' => $value,
                    'headers' => ['Content-Type' => "application/octet-stream;charset=$charset"],
                ];
            } else {
                $multipart[] = [
                    'name' => $key,
                    'contents' => $value,
                    'headers' => ['Content-Type' => "text/plain;charset=$charset"],
                ];
            }
        }

        $v = $this->version();
        $h = new CommonResultHandler(function ($rsp) use ($v) {
            switch ($v) {
                case self::VERSION_V2:
                    return $rsp[self::DATA];
            }

            return null;
        });

        $headers = ['Content-Type' => 'multipart/form-data'];

        return $this->path('add_tpl.json')->post($multipart, $h, $r, $headers);
    }

    /**
     * 获取视频短信模版状态
     *
     * @param array $param
     *
     * @return \Modules\Common\Utils\SMS\YunPian\Model\Result|null
     */
    public function getTpl($param = [])
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
                    return $rsp[self::DATA];
            }

            return null;
        });

        return $this->path('get_tpl.json')->post($param, $h, $r);
    }

    /**
     * 批量发送视频短信
     *
     * @return \Modules\Common\Utils\SMS\YunPian\Model\Result|null
     */
    public function tplBatchSend(array $param)
    {
        static $must = [self::APIKEY, self::MOBILE, self::TPL_ID];
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

        return $this->path('tpl_batch_send.json')->post($param, $h, $r);
    }
}
