<?php

namespace Modules\Common\Utils\Base;

use Modules\Common\Entities\SmsLog;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;

class SmsUtils
{
    public static function sms(string $mobile, string $code): bool
    {
        try {
            $sms = app('easysms');

            $text = env('YUNPIAN_SIGNATURE') . '正在进行登录操作，您的验证码是' . $code;

            $res = $sms->send($mobile, [
                'content' => $text,
            ]);

            $smsLog = new SmsLog();
            $smsLog->saveLog($mobile, $text, $code, 1, jsonEncode($res));

            return true;
        } catch (NoGatewayAvailableException $exception) {
            abort(200, $exception->getLastException()->getMessage());
        }
    }
}
