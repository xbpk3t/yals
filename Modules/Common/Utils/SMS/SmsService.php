<?php

namespace Modules\Common\Utils\SMS;

use Modules\Common\Utils\SMS\YunPian\YunpianClient;

class SmsService
{
    public static function sms(string $mobile)
    {
        $smsDriver = config('services.sms.default');

        switch ($smsDriver) {
            case 'yp':
                $clnt = YunpianClient::create(env('YUNPIAN_API_KEY'));
                $param = [YunpianClient::MOBILE => $mobile, YunpianClient::TEXT => '【高嵋111】正在进行登录操作，您的验证码是1234'];
                $r = $clnt->sms()->single_send($param);
                dd($r);
                // no break
            default:
                return '暂不支持';
        }
    }
}
