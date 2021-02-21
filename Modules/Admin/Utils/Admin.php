<?php

namespace Modules\Admin\Utils;

use Modules\Admin\Entities\AdminUser;
use Modules\Api\Entities\User;

/**
 * Class Admin
 * @package Modules\Admin\Utils
 */
class Admin
{
    /**
     * 当前登录管理员.
     *
     * @return AdminUser
     */
    public static function user()
    {
        return static::guard()->user();
    }

    /**
     * 当前登录管理员是不是超级管理员.
     *
     * @return bool
     */
    public static function isAdministrator()
    {
//        return static::user() && static::user()->isAdministrator();
        return static::user()->isAdministrator();
    }

    /**
     * 把路径自动拼上后端的路径前缀
     *
     * @param string $path
     *
     * @return string
     */
    public static function url($path = '')
    {
        $prefix = 'admin-api';
        $path = trim($path, '/');

        if (null == $path || 0 == mb_strlen($path)) {
            $path = $prefix;
        } else {
            $path = $prefix . '/' . $path;
        }

        return $path;
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Tymon\JWTAuth\JWTGuard|\Tymon\JWTAuth\JWT
     */
    public static function guard()
    {
        return auth('admin');
    }

    /**
     * 获取管理员目录路径.
     *
     * @param string $path
     *
     * @return string
     */
    public static function path(string $path = '')
    {
        return app_path('Admin' . ($path ? (DIRECTORY_SEPARATOR . ltrim($path, '\/')) : ''));
    }
}
