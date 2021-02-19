<?php


namespace Modules\Common\Utils\ApiEncrypt\AES;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class AesDecryptMiddleware
{
    /**
     * @var Encrypter
     */
    protected $encrypt;

    public function __construct(Encrypter $encrypt){
        $this->encrypt = $encrypt;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){

        if ($request->getContent() == null || $request->getContent() == '') {
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
     * decrypt the content
     * @param string $content
     * @return string
     */
    protected function decrypt(string $content){
        return $this->encrypt->decrypt($content, false);
    }

    /**
     * put the decrypt data into request
     * @param Request $request
     * @param string $content
     * @return Request
     */
    protected function putIn(Request $request, string $content){

        if ($request->getContentType() === 'json') {
            $request->setJson(new ParameterBag((array) jsonDecode($content)));
        } else {
            $request->attributes = new ParameterBag([$request->getContentType() => $content]);
        }

        return $request;
    }
}
