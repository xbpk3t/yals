<?php

namespace Modules\Common\Utils\Base;

use GuzzleHttp\Client;

trait GuzzleTrait
{
    protected $guzzleOption = [];

    public function getHttpClient()
    {
        return new Client($this->guzzleOption);
    }

    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOption = $options;
    }
}
