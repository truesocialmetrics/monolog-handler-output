<?php
namespace TweeMonolog\Handler;
use Monolog\Handler\AbstractProcessingHandler;

class ConsoleOutput extends AbstractProcessingHandler
{
    protected function write(array $record)
    {
        /*
        $record = array(
            'message' => (string) $message,
            'context' => $context,
            'level' => $level,
            'level_name' => static::getLevelName($level),
            'channel' => $this->name,
            'datetime' => \DateTime::createFromFormat('U.u', sprintf('%.6F', microtime(true)), static::$timezone)->setTimezone(static::$timezone),
            'extra' => array(),
        );
        */
        echo $record['datetime'] 
            . ' => ' . $record['level_name'] 
            . ' => ' . $record['message'] 
            . PHP_EOL
            . var_export($record['context'], true) . PHP_EOL
            . var_export($record['extra'], true) . PHP_EOL;
    }
}