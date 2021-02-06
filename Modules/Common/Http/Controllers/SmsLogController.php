<?php

namespace Modules\Common\Http\Controllers;

use Modules\Common\Entities\SmsLog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SmsLogController extends Controller
{
    public function sendSms(Request $request)
    {
        dd(1);
    }
}
