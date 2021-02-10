<?php

namespace Modules\Common\Utils\Coupon;

use Modules\Common\Utils\Coupon\CouponList;

class Coupon extends CouponTemplate implements CouponInterface
{
    public function create(int $userId, int $couponId)
    {
        $couponList = new CouponList();
        $couponInfo = $couponList->couponInfo($couponId);

        // 红包id，红包名称，红包有效期，红包内容，用户id，价格，类型
        $this->userId = $userId;
        $this->couponId = $couponId;
        $this->couponName = $couponInfo->name;
        $this->couponContent = $couponInfo->contents;
        $this->expires = afterNowFormat('day', $couponInfo->expires);

        $this->price = $couponInfo->price;
        $this->type = $couponInfo->type;
        $this->extend = [];

        return $this;
    }
}
