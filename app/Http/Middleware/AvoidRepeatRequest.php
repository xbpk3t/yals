<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

// 限流具体用户的某个请求
class AvoidRepeatRequest extends Middleware
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
        // 如果用户已登录直接传用户的token
        $isTokenExist = $request->hasHeader('Authorization');
        if ($isTokenExist) {
            $token = $request->header('Authorization');
            $router = $request->getPathInfo();
            $key = $router . $token;

            $lock = Cache::lock($key, 10);
            $res = $lock->get();

            if (!$res) {
                // todo 写入日志
                return response(['code' => 503, 'message' => '请求太频繁', 'data' => []], 503);
            }

            return $next($request);
        }

        return $next($request);
    }
}
