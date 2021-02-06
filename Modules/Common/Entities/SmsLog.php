<?php

namespace Modules\Common\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;

    protected $table = "tz_sms_log";

    const UPDATED_AT = null;
}
