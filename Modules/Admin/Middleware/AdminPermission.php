<?php

namespace Modules\Admin\Middleware;

use Modules\Admin\Middleware\PermissionMiddleware;

class AdminPermission extends PermissionMiddleware
{
    protected $urlWhitelist = [
        '/auth/login',
        '/auth/logout',
        '/user',
        '/user/edit',
        '/configs/vue-routers',
        '/configs/system_basic/values',
    ];
}
