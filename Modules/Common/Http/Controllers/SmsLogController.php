<?php

namespace Modules\Common\Http\Controllers;

use Modules\Common\Utils\SMS\SmsService;
use Modules\Common\Http\Requests\SendSmsRequest;

class SmsLogController extends BaseController
{
    public function sendSms(SendSmsRequest $request)
    {
        SmsService::sms($request->mobile);
    }
}
