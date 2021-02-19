<?php

namespace Modules\Common\Utils\SMS\YunPian\Model;

use Modules\Common\Utils\SMS\YunPian\Constant\Code;

/**
 * Result of HttpClient Response.
 *
 * @author dzh
 *
 * @since 1.0
 */
class Result
{
    /**
     * @var int
     */
    private $code = Code::OK;

    /**
     * @var string
     */
    private $msg;

    /**
     * @var string
     */
    private $detail;

    /**
     * @var \Exception
     */
    private $e;

    /**
     * json.
     *
     * @var mixed
     */
    private $data;

//    public function __toString()
//    {
//        return "{$this->code}-{$this->msg}-{$this->detail}";
//    }

    public function isSucc()
    {
        return Code::OK == $this->code;
    }

    /**
     * @param number $code
     * @param bool   $rr
     *
     * @return number|\Modules\Common\Utils\SMS\YunPian\Model\Result
     */
    public function code($code = null, $rr = false)
    {
        if (isset($code) || $rr) {
            $this->code = $code;

            return $this;
        }

        return $this->code;
    }

    /**
     * @param string $msg
     * @param bool   $rr
     *                    force to return $this
     *
     * @return string|\Modules\Common\Utils\SMS\YunPian\Model\Result
     */
    public function msg($msg = null, $rr = false)
    {
        if (isset($msg) || $rr) {
            $this->msg = $msg;

            return $this;
        }

        return $this->msg;
    }

    /**
     * @param string $detail
     * @param bool   $rr
     *                       force to return $this
     *
     * @return string|\Modules\Common\Utils\SMS\YunPian\Model\Result
     */
    public function detail($detail = null, $rr = false)
    {
        if (isset($detail) || $rr) {
            $this->detail = $detail;

            return $this;
        }

        return $this->detail;
    }

    /**
     * @param \Exception $e
     * @param bool $rr
     * @return $this|\Exception
     */
    public function exception(\Exception $e, bool $rr)
    {
        if ($rr) {
            $this->e = $e;

            return $this;
        }

        return $this->e;
    }

    /**
     * @param array $data
     * @param bool  $rr
     *
     * @return array|\Modules\Common\Utils\SMS\YunPian\Model\Result
     */
    public function data($data = null, $rr = false)
    {
        if (isset($data) || $rr) {
            $this->data = $data;

            return $this;
        }

        return $this->data;
    }
}
