<?php

namespace Modules\Common\Utils\SMS\YunPian\Api;

use Modules\Common\Utils\SMS\YunPian\Model\Result;
use Modules\Common\Utils\SMS\YunPian\Constant\Code;
use Modules\Common\Utils\SMS\YunPian\YunpianClient;
use Modules\Common\Utils\SMS\YunPian\Constant\YunpianConstant;

/**
 * @author dzh
 *
 * @since 1.0
 */
abstract class YunpianApi implements YunpianApiResult, YunpianConstant
{
    /**
     * @var YunpianClient
     */
    private $clnt;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $apikey;

    /**
     * @var string
     */
    private $charset;

    /**
     * @param YunpianClient $client
     */
    public function init(YunpianClient $clnt)
    {
        if (null === $clnt) {
            return;
        }
        $this->clnt = $clnt;
        $this->apikey = $clnt->apikey();
        $this->version = $clnt->conf(self::YP_VERSION, self::VERSION_V2);
        $this->charset = $clnt->conf(self::HTTP_CHARSET, self::HTTP_CHARSET_DEFAULT);
    }

    /**
     * @return string
     */
    abstract public function name();

    /**
     * @param YunpianClient $client
     *
     * @return \Modules\Common\Utils\SMS\YunPian\YunpianClient|\Modules\Common\Utils\SMS\YunPian\Api\YuanpianApi
     */
    public function client(YunpianClient $clnt = null)
    {
        if (null === $clnt) {
            return $this->clnt;
        }
        $this->clnt = $clnt;

        return $this;
    }

    /**
     * @param string $host
     *
     * @return string|\Modules\Common\Utils\SMS\YunPian\Api\YuanpianApi
     */
    public function host($host = null)
    {
        if (null === $host) {
            return $this->host;
        }
        $this->host = $host;

        return $this;
    }

    /**
     * @param string $version
     *
     * @return \Modules\Common\Utils\SMS\YunPian\YunpianConf|\Modules\Common\Utils\SMS\YunPian\Api\YuanpianApi
     */
    public function version($version = null)
    {
        if (null === $version) {
            return $this->version;
        }
        $this->version = $version;

        return $this;
    }

    /**
     * @param string $path
     *
     * @return \Modules\Common\Utils\SMS\YunPian\Api\YuanpianApi | string
     */
    public function path($path = null)
    {
        if (null === $path) {
            return $this->path;
        }
        $this->path = $path;

        return $this;
    }

    /**
     * @param string $apikey
     *
     * @return string|\Modules\Common\Utils\SMS\YunPian\Api\YuanpianApi
     */
    public function apikey($apikey = null)
    {
        if (null === $apikey) {
            return $this->apikey;
        }
        $this->apikey = $apikey;

        return $this;
    }

    /**
     * @param string $charset
     *
     * @return string|\Modules\Common\Utils\SMS\YunPian\Api\YuanpianApi
     */
    public function charset($charset = null)
    {
        if (null === $charset) {
            return $this->charset;
        }
        $this->charset = charset;

        return $this;
    }

    /**
     * @return string
     */
    public function uri()
    {
        return "{$this->host}/{$this->version}/{$this->name()}/{$this->path}";
    }

    /**
     * @param ResultHandler $h
     * @param Result        $r
     *
     * @return \Modules\Common\Utils\SMS\YunPian\Model\Result
     */
    public function post(array &$param, ResultHandler $h = null, Result $r = null, array &$headers = null)
    {
        try {
            $rsp = $this->clnt->post($this->uri(), $param, $this->charset(), $headers);

            return $this->result($rsp, $h, $r);
        } catch (\Exception $e) {
            return $h->catchExceptoin($e, $r);
        }
    }

    public function result(array $rsp, ResultHandler $h = null, Result $r = null)
    {
        // if (is_null($h)) { TODO
        // $h = // default handler
        // }
        if (null === $r) {
            $r = new Result();
        }

        $code = $this->code($rsp, $this->version);

        return Code::OK == $code ? $h->succ($code, $rsp, $r) : $h->fail($code, $rsp, $r);
    }

    public function code(array &$rsp, $version = YunpianConstant::VERSION_V2)
    {
        if (null === $rsp) {
            return Code::OK;
        }
        $code = Code::UNKNOWN_EXCEPTION;
        if (null === $version) {
            $version = self::VERSION_V2;
        }
        if (isset($rsp)) {
            switch ($version) {
                case self::VERSION_V1:
                    $code = array_key_exists(self::CODE, $rsp) ? (int) $rsp[self::CODE] : Code::UNKNOWN_EXCEPTION;
                    break;
                case self::VERSION_V2:
                    $code = array_key_exists(self::CODE, $rsp) ? (int) $rsp[self::CODE] : Code::OK;
                    break;
            }
        }

        return $code;
    }

    /**
     * @param Result $r
     *
     * @return Result
     */
    public function verifyParam(array &$param, array &$must, Result $r = null)
    {
        if (null === $r) {
            $r = new Result();
        }
        if (!array_key_exists(self::APIKEY, $param)) {
            $param[self::APIKEY] = $this->apikey;
        }
        if (isset($must)) {
            foreach ($must as $p) {
                if (!array_key_exists($p, $param)) {
                    $r->code(Code::ARGUMENT_MISSING)->detail($p);
                    break;
                }
            }
        }

        return $r;
    }
}
