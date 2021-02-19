<?php

namespace Modules\Common\Utils\ApiEncrypt\AES;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\Encrypter;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Contracts\Encryption\DecryptException;

class AesDecryptMiddleware
{
    /**
     * @var Encrypter
     */
    protected $encrypt;

    public function __construct(Encrypter $encrypt)
    {
        $this->encrypt = $encrypt;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (null == $request->getContent() || '' == $request->getContent()) {
            return $next($request);
        }

        try {
            $content = $this->decrypt($request->getContent());
        } catch (DecryptException $exception) {
            abort(403);
        }

        return $next($this->putIn($request, $content));
    }

    /**
     * decrypt the content.
     *
     * @return string
     */
    protected function decrypt(string $content)
    {
        return $this->encrypt->decrypt($content, false);
    }

    /**
     * put the decrypt data into request.
     *
     * @return Request
     */
    protected function putIn(Request $request, string $content)
    {
        if ('json' === $request->getContentType()) {
            $request->setJson(new ParameterBag((array) jsonDecode($content)));
        } else {
            $request->attributes = new ParameterBag([$request->getContentType() => $content]);
        }

        return $request;
    }
}
