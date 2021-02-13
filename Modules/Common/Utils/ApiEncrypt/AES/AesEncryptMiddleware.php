<?php


namespace Modules\Common\Utils\ApiEncrypt\AES;

use Closure;
use Dingo\Api\Http\Response as DingoResponse;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;
use Illuminate\Http\Response;

class AesEncryptMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // 只对200进行加密
        if ($response->getStatusCode() != 200) {
            return $response;
        }

        if ($response instanceof DingoResponse) {
            $value = $response->getContent();
        }

        if ($response instanceof Response) {
            $value = $response->getContent();
        }
        return response(encrypt((string) $value, false));
//        return response(app()->make(Encrypter::class)
//            ->encrypt((string) $value, false));
    }
}
