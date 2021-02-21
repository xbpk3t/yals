<?php

namespace Modules\Common\Controllers;

use Modules\Common\Utils\Base\SmsUtils;
use Modules\Common\Requests\SMS\SendSmsRequest;

class SmsLogController extends BaseController
{
    public function sendSms(SendSmsRequest $request): object
    {
        $res = SmsUtils::sms($request->mobile, smsCode());
        if ($res) {
            return $this->okMsg('短信发送成功');
        }

        return $this->okMsg('短信发送失败');
    }
}
