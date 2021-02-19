<?php

namespace Modules\Common\Controllers;

use Modules\Common\Utils\SMS\SmsService;
use Modules\Common\Requests\SendSmsRequest;

class SmsLogController extends BaseController
{
    public function sendSms(SendSmsRequest $request): object
    {
        $res = SmsService::sms($request->mobile, smsCode());
        if ($res) {
            return $this->okMsg('短信发送成功');
        }

        return $this->okMsg('短信发送失败');
    }
}
