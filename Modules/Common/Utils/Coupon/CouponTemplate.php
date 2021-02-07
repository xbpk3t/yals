<?php

namespace Modules\Common\Utils\Coupon;

class CouponTemplate
{
    // 优惠券id
    public $couponId;
    // 优惠券内容
    public $couponContent;
    // 优惠券名称
    public $couponName;
    // 有效期
    public $expires;
    // 用户id
    public $userId;
    // 抵扣金额
    public $price;
    // 状态
    public $ss;
    // 类型，默认0通用红包，1其他类型
    public $type;
    // 拓展字段
    public $extend;

    /**
     * 用来包装一下接口类里创建红包的方法.
     *
     * @param CouponInterface $coupon
     * @param int             $userId
     * @param int             $couponId
     *
     * @return object
     */
    public function provider(CouponInterface $coupon, int $userId, int $couponId): object
    {
        return $coupon->create($userId, $couponId);
    }

    public function consumer($number)
    {
        // $number 是卷号，这里一般都是操作redis，mysql的统一逻辑。
    }
}
