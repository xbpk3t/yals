<?php

namespace Modules\Common\Utils\Signature\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Modules\Common\Utils\Signature\Exception\InvalidSignatureException;
use \Illuminate\Http\Request;

class SignatureMiddleware
{
    /**
     * The Laravel Application.
     */
    protected $nonceKey = 'api:nonce:';

    const TIME_OUT = 1800;

    protected $signKeys = [
        'app_id',
        'timestamp',
        'nonce',
        'http_method',
        'http_path',
    ];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     * @throws InvalidSignatureException
     */
    public function handle($request, Closure $next)
    {
        $this->validSign($request);

        return $next($request);
    }

    /**
     * @param array $params
     * @param string $secret
     * @return string
     */
    public function sign(array $params, string $secret): string
    {
        $params = array_filter($params, function ($value, $key) {
            return in_array($key, $this->signKeys);
        }, ARRAY_FILTER_USE_BOTH);

        ksort($params);

        return hash_hmac('sha256', http_build_query($params, null, '&'), $secret);
    }

    /**
     * Validate signature.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     * @throws InvalidSignatureException
     */
    public function validSign(Request $request = null): bool
    {
        if (!$request->has('timestamp') || !$request->has('nonce') || !$request->has('sign')) {
            throw new InvalidSignatureException('缺少接口签名参数');
        }

        $timestamp = (int) $request->input('timestamp', 0);
        $nonce = $request->input('nonce');
        $sign = $request->input('sign');
        $signParams = $request->input();
        $secret = config('api-custom.signature.secret');

        $signParams = \array_merge($signParams, [
            'http_method' => $request->method(),
            'http_path'   => $request->getPathInfo(),
        ]);

        $this->validTimestamp($timestamp)
            ->validNonce($nonce)
            ->validHashMac($signParams, $secret, $sign);

        $this->setNonceCache($nonce);

        return true;
    }

    /**
     * @param array $params
     * @param string $secret
     * @param string $sign
     * @return $this
     * @throws InvalidSignatureException
     */
    private function validHashMac(array $params, string $secret, string $sign)
    {
        if (! hash_equals($this->sign($params, $secret), $sign)) {
            throw new InvalidSignatureException('Invalid Signature');
        }

        return $this;
    }

    /**
     * @param int $time
     * @return $this
     * @throws InvalidSignatureException
     */
    private function validTimestamp(int $time)
    {
        $currentTime = time();

        if ($time <= 0 || $time > $currentTime || $currentTime - $time > self::TIME_OUT) {
            throw new InvalidSignatureException('Time out.');
        }

        return $this;
    }

    /**
     * @param string $nonce
     * @return $this
     * @throws InvalidSignatureException
     */
    private function validNonce(string $nonce)
    {
        if (Cache::has($this->getNonceCacheKey($nonce))) {
            throw new InvalidSignatureException('Not nonce');
        }

        return $this;
    }

    /**
     * @param string $nonce
     * @return bool
     */
    private function setNonceCache(string $nonce): bool
    {
        // todo unittest里Cache无法set值，但是会返回true
        return Cache::add($this->getNonceCacheKey($nonce), 1, self::TIME_OUT / 60);
    }

    /**
     * @param string $nonce
     * @return string
     */
    private function getNonceCacheKey(string $nonce): string
    {
        return $this->nonceKey.$nonce;
    }
}
