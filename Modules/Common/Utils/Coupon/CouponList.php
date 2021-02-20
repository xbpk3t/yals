<?php


namespace Modules\Common\Utils\Coupon;

use Illuminate\Database\Eloquent\Model;
use Modules\Common\Entities\Base\Json;

// 如果需要优惠券模块，把该model放到对应文件夹下
class CouponList extends Model
{
    protected $table = 'tz_coupon_list';

    protected $fillable = ['user_id', 'coupon_id', 'coupon_name', 'coupon_content', 'expires', 'price', 'type', 'extend'];

    protected $casts = [
        // 红包extend强转json
        'extend' => Json::class
    ];
}
