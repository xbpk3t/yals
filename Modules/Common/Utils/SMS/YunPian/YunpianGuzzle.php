<?php

namespace Modules\Common\Utils\SMS\YunPian;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Modules\Common\Utils\SMS\YunPian\Constant\YunpianConstant;

/**
 * @author dzh
 *
 * @since 1.0
 */
trait YunpianGuzzle
{
    /**
     * @var Client
     */
    private $http;

    /**
     * http charset.
     *
     * @var string
     */
    private $charset;

    /**
     * @param string $uri
     * @param string $charset
     * @param array  $headers
     * @param string $parse
     *                        Parsing function for Response, as if toJson
     *
     * @return mixed
     */
    public function post($uri, array &$data, $charset = null, array &$headers = null, $parse = 'toJson')
    {
        if (null === $charset) {
            $charset = $this->charset;
        }
        if (null === $headers) {
            $headers = ['Content-Type' => "application/x-www-form-urlencoded;charset=$charset"];
        }

        $options = ['debug' => false, '_conditional' => $headers];

        if ('multipart/form-data' == $headers['Content-Type']) {
            $options['multipart'] = $data;
        } else {
            $options['form_params'] = $data;
        }

        try {
            $rsp = $this->http()->post($uri, $options);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $rsp = $e->getResponse();
        }

        return null === $parse ? $rsp : $this->$parse($rsp);
    }

    /**
     * @return mixed
     */
    public function toJson(ResponseInterface $rsp)
    {
        return \GuzzleHttp\json_decode($rsp->getBody()->getContents(), true);
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function http()
    {
        return $this->http;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    protected function initHttp(YunpianConf $conf)
    {
        $client = new Client($this->httpDefOptions($conf));

        $this->charset = $conf->conf(YunpianConstant::HTTP_CHARSET, YunpianConstant::HTTP_CHARSET_DEFAULT);
        $this->http = $client;

        return $client;
    }

    protected function httpDefOptions(YunpianConf $conf)
    {
        return ['headers' => ['Api-Lang' => 'php',
                              'timeout' => intval($conf->conf(YunpianConstant::HTTP_SO_TIMEOUT, 30)),
                              'connect_timeout' => intval($conf->conf(YunpianConstant::HTTP_CONN_TIMEOUT, 10)), ]];
        // 'Content-Type' => 'application/x-www-form-urlencoded'
    }
}
