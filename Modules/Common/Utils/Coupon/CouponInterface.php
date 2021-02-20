<?php

namespace Modules\Common\Utils\Coupon;

interface CouponInterface
{
    public function create(int $userId, int $couponId);
}
