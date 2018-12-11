<?php
/**
 * Created by PhpStorm.
 * User: cheolwon
 * Date: 2018-12-11
 * Time: 23:19
 */

namespace App\Logging;

use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\UidProcessor;
use Monolog\Processor\WebProcessor;

class CustomFormatter
{
    /**
     * @param \Illuminate\Log\Logger $logger
     */
    public function __invoke($logger)
    {
        foreach ($logger->getHandlers() as $handler) {
            $formatter = new LineFormatter("[%datetime%] %channel%.%level_name%: [%message%] context.%context% extra.%extra%\n");
            $handler->setFormatter($formatter);
            $handler->pushProcessor(new ProcessIdProcessor());
            $handler->pushProcessor(new UidProcessor());
            $handler->pushProcessor(new WebProcessor());
            $handler->pushProcessor(new MemoryPeakUsageProcessor());
            $handler->pushProcessor(new IntrospectionProcessor(Logger::DEBUG, [], 4));
        }
    }
}