<?php

namespace Modules\Common\Logging;

use Monolog\Logger;

/**
 * Class CustomizeFormatter
 * @package Modules\Common\Logging
 */
class CustomizeFormatter
{
    /**
     * 自定义给定的日志实例.
     * @param Logger $logger
     */
    public function __invoke(Logger $logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new CustomizeJsonFormatter());
        }
    }
}
