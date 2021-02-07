<?php

namespace Modules\Common\Controllers;

use Modules\Common\Utils\SMS\SmsService;
use Modules\Common\Requests\SendSmsRequest;

class SmsLogController extends BaseController
{
    public function sendSms(SendSmsRequest $request)
    {
        SmsService::sms($request->mobile, smsCode());
    }
}
