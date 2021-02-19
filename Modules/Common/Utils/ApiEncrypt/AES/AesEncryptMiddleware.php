<?php

namespace Modules\Common\Utils\ApiEncrypt\AES;

use Closure;
use Illuminate\Http\Response;
use Dingo\Api\Http\Response as DingoResponse;

class AesEncryptMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // 只对200进行加密
        if (200 != $response->getStatusCode()) {
            return $response;
        }

        $value = '';

        if ($response instanceof DingoResponse) {
            $value = $response->getContent();
        }

        if ($response instanceof Response) {
            $value = $response->getContent();
        }

        return response(encrypt($value, false));
    }
}
