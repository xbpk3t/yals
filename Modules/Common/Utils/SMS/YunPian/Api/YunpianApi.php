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
     * @param YunpianClient $clnt
     */
    public function init(YunpianClient $clnt)
    {
        $this->clnt = $clnt;
        $this->apikey = $clnt->apikey();
//        $this->version = $clnt->conf(self::YP_VERSION, self::VERSION_V2);
//        $this->charset = $clnt->conf(self::HTTP_CHARSET, self::HTTP_CHARSET_DEFAULT);
        $this->version = $clnt->conf(self::YP_VERSION);
        $this->charset = $clnt->conf(self::HTTP_CHARSET);
    }

    /**
     * @return string
     */
    abstract public function name();

    /**
     * @param YunpianClient|null $clnt
     * @return $this|YunpianClient
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
     * @return $this|string
     */
    public function host(string $host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    public function version()
    {
//        if (null === $version) {
//            return $this->version;
//        }
//        $this->version = $version;
//
//        return $this;

        return $this->version;
    }

    /**
     * @param string $path
     * @return $this|string
     */
    public function path(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @param string $apikey
     * @return $this|string
     */
    public function apikey(string $apikey)
    {
        $this->apikey = $apikey;

        return $this;
    }

    /**
     * @return string
     */
    public function charset()
    {
        return $this->charset;
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
            return $h->catchException($e, $r);
        }
    }

    public function result(array $rsp, ResultHandler $h = null, Result $r = null)
    {
        if (null === $r) {
            $r = new Result();
        }

        $code = $this->code($rsp, $this->version);

        return Code::OK == $code ? $h->succ($code, $rsp, $r) : $h->fail($code, $rsp, $r);
    }

    public function code(array &$rsp, $version = YunpianConstant::VERSION_V2):int
    {
        $code = Code::UNKNOWN_EXCEPTION;

        switch ($version) {
            case self::VERSION_V1:
                $code = array_key_exists(self::CODE, $rsp) ? (int) $rsp[self::CODE] : Code::UNKNOWN_EXCEPTION;
                break;
            case self::VERSION_V2:
                $code = array_key_exists(self::CODE, $rsp) ? (int) $rsp[self::CODE] : Code::OK;
                break;
        }

        return $code;
    }

    /**
     * @param array $param
     * @param array $must
     * @param Result|null $r
     * @return Result|null
     */
    public function verifyParam(array &$param, array &$must, Result $r = null)
    {
        if (!array_key_exists(self::APIKEY, $param)) {
            $param[self::APIKEY] = $this->apikey;
        }
        foreach ($must as $p) {
            if (!array_key_exists($p, $param)) {
                $r->code(Code::ARGUMENT_MISSING)->detail($p);
                break;
            }
        }

        return $r;
    }
}
