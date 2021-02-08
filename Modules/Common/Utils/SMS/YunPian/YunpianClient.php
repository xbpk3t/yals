<?php

namespace Modules\Common\Utils\SMS\YunPian;

use Modules\Common\Utils\SMS\YunPian\Api\SmsApi;
use Modules\Common\Utils\SMS\YunPian\Api\TplApi;
use Modules\Common\Utils\SMS\YunPian\Api\FlowApi;
use Modules\Common\Utils\SMS\YunPian\Api\SignApi;
use Modules\Common\Utils\SMS\YunPian\Api\UserApi;
use Modules\Common\Utils\SMS\YunPian\Api\VoiceApi;
use Modules\Common\Utils\SMS\YunPian\Api\ApiFactory;
use Modules\Common\Utils\SMS\YunPian\Api\VideoSmsApi;
use Modules\Common\Utils\SMS\YunPian\Constant\YunpianConstant;

/**
 * @author dzh
 *
 * @since 1.0
 */
class YunpianClient implements YunpianConstant
{
    use YunpianGuzzle;

    /**
     * @var ApiFactory
     */
    private $api;

    /**
     * @var YunpianConf
     */
    private $conf;

    public function __construct()
    {
        $this->api = new ApiFactory($this);
        $this->conf = new YunpianConf();
    }

    public function __destruct()
    {
        // print "Destroying $this\n";
    }

    public function __toString()
    {
        return "YunpianClient-{$this->apikey()}";
    }

    /**
     * Initialize/Create YunpianClient.
     *
     * @param string $apikey
     *
     * @return \Modules\Common\Utils\SMS\YunPian\YunpianClient
     */
    public static function create($apikey, array $conf = [])
    {
        $clnt = new self();
        $clnt->conf->init()->with($apikey, $conf);
        $clnt->initHttp($clnt->conf); // YunpianGuzzle->initHttp

        return $clnt;
    }

    /**
     * @return Api\YunpianApi
     */
    public function sms()
    {
        return $this->api(SmsApi::NAME);
    }

    /**
     * @return Api\YunpianApi
     */
    public function vsms()
    {
        return $this->api(VideoSmsApi::NAME);
    }

    /**
     * @return Api\YunpianApi
     */
    public function user()
    {
        return $this->api(UserApi::NAME);
    }

    /**
     * @return Api\YunpianApi
     */
    public function voice()
    {
        return $this->api(VoiceApi::NAME);
    }

    /**
     * @return Api\YunpianApi
     */
    public function sign()
    {
        return $this->api(SignApi::NAME);
    }

    /**
     * @return Api\YunpianApi
     */
    public function tpl()
    {
        return $this->api(TplApi::NAME);
    }

    /**
     * @return Api\YunpianApi
     */
    public function flow()
    {
        return $this->api(FlowApi::NAME);
    }

    public function conf($key = null)
    {
        return null === $key ? $this->conf : $this->conf->conf($key);
    }

    public function apikey()
    {
        return $this->conf->apikey();
    }

    /**
     * @param string $name
     *
     * @return \Modules\Common\Utils\SMS\YunPian\Api\YunpianApi
     */
    private function api($name)
    {
        return $this->api->api($name);
    }
}
