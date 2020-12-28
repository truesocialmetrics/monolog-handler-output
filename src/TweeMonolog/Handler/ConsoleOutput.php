<?php
namespace TweeMonolog\Handler;
use Monolog\Handler\AbstractProcessingHandler;

class ConsoleOutput extends AbstractProcessingHandler
{
    protected function write(array $record): void
    {
        echo $record['formatted'];
    }
}
