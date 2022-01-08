<?php

namespace Modules\Admin\Middleware;

use Closure;
use Modules\Admin\Entities\AdminUser;

class JwtAuthAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        config(['jwt.user' => AdminUser::class]); //用于重定位model
        config(['auth.providers.users.model' => AdminUser::class]); //用于重定位model

        return $next($request);
    }
}
