<?php

namespace Modules\Common\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmsLog extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $table = 'tz_sms_log';

    protected $guarded = ['id'];

    public function saveLog(string $mobile, string $content, string $code, string $type, string $response, int $userId = null)
    {
        return self::create(['mobile' => $mobile, 'content' => $content, 'code' => $code, 'type' => $type, 'response' => $response, 'user_id' => $userId]);
    }
}
