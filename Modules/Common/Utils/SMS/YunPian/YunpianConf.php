<?php

namespace Modules\Common\Utils\SMS\YunPian;

use Modules\Common\Utils\SMS\YunPian\Constant\YunpianConstant;

/**
 * @author dzh
 *
 * @since 1.0
 */
class YunpianConf implements YunpianConstant
{
    /**
     * @var array
     */
    private $conf = [];

    /**
     * to upsert $conf.
     *
     * @param string $apikey
     *
     * @return \Modules\Common\Utils\SMS\YunPian\YunpianConf
     */
    public function with($apikey, array $conf = [])
    {
        if (!empty($conf)) {
            foreach ($conf as $key => $value) {
                $this->conf[$key] = $value;
            }
        }

        if (isset($apikey)) {
            $this->conf[self::YP_APIKEY] = $apikey;
        }

        return $this;
    }

    /**
     * load yunpian.ini to initialize YunpianConf firstly:
     * <p>.
     *
     * </p>
     *
     * @return Yunpian\Sdk\YunpianConf
     */
    public function init()
    {
        if (null === $this->conf) {
            $this->conf = [];
        }

        $yp = parse_ini_file('yunpian.ini');
        foreach ($yp as $key => $value) {
            $this->conf[$key] = $value;
        }

        return $this;
    }

    /**
     * @param string $key
     * @param mixed  $defval
     *
     * @return mixed
     */
    public function conf($key = null, $defval = null)
    {
        if (null === $key) {
            return $this->conf;
        }
        $val = $this->conf[$key];

        return null === $val ? $defval : $val;
    }

    /**
     * @return string
     */
    public function apikey()
    {
        return $this->conf[self::YP_APIKEY];
    }
}
