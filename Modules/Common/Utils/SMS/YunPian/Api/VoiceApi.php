<?php

namespace Modules\Common\Utils\SMS\YunPian\Api;

use Modules\Common\Utils\SMS\YunPian\Model\Result;
use Modules\Common\Utils\SMS\YunPian\YunpianClient;

/**
 * https://www.yunpian.com/api2.0/voice.html.
 *
 * @author dzh
 *
 * @since 1.0
 */
class VoiceApi extends YunpianApi
{
    const NAME = 'voice';

    public function init(YunpianClient $clnt)
    {
        parent::init($clnt);
//        $this->host($clnt->conf(self::YP_VOICE_HOST, 'https://voice.yunpian.com'));
        $this->host($clnt->conf(self::YP_VOICE_HOST));
    }

    public function name()
    {
        return self::NAME;
    }

    /**
     * @param array $param
     * @return Result|null
     */
    public function send(array $param)
    {
        static $must = [self::APIKEY, self::MOBILE, self::CODE];
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

        return $this->path('send.json')->post($param, $h, $r);
    }

    /**
     * @param array $param
     * @return Result|null
     */
    public function pull_status(array $param)
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
                    return $rsp[self::VOICE_STATUS];
                case self::VERSION_V2:
                    return $rsp;
            }

            return null;
        });

        return $this->path('pull_status.json')->post($param, $h, $r);
    }
}
