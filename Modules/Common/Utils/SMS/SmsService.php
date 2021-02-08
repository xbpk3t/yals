<?php

namespace Modules\Common\Utils\SMS;

use Modules\Common\Entities\SmsLog;
use Modules\Common\Utils\SMS\YunPian\YunpianClient;

class SmsService
{
    public static function sms(string $mobile, string $code)
    {
        $smsDriver = config('services.sms.default');

        $smsLog = new SmsLog();

        switch ($smsDriver) {
            case 'yp':
                $clnt = YunpianClient::create(config('services.sms.yp.api_key'));
                $signature = config('services.sms.yp.signature');

                $text = sprintf('%s%s', sprintf('【%s】', $signature), "正在进行登录操作，您的验证码是$code");
                $param = [
                    YunpianClient::MOBILE => $mobile,
                    YunpianClient::TEXT => $text,
                ];

                $res = $clnt->sms()->singleSend($param);
                $response = jsonEncode(['code' => $res->code(), 'msg' => $res->msg(), 'data' => $res->data()]);

                // 入库
                $smsLog->saveLog($mobile, $text, $code, 1, $response);

                abort_if(!$res->isSucc(), 200, '发送短信错误');
                // no break
            default:
                abort(200, '暂不支持该短信通道');
        }
    }
}
