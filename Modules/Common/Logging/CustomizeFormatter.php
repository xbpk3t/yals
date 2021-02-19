<?php

namespace Modules\Common\Logging;

use Monolog\Logger;

class CustomizeFormatter
{
    /**
     * 自定义给定的日志实例.
     */
    public function __invoke(Logger $logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter(new CustomizeJsonFormatter());
        }
    }
}
