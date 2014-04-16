<?php
namespace TweeMonolog\Handler;
use PHPUnit_Framework_TestCase;
use ReflectionMethod;

class ConsoleOutputTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $handler = new ConsoleOutput();
        $method = new ReflectionMethod($handler, 'write');
        $method->setAccessible(true);
        ob_start();
        //$handler->write(array('email' => 'x@x.com'));
        $method->invokeArgs($handler, array('record' => array(
            'datetime' => '2014-01-01 11:11:11',
            'message' => 'my test message',
            'level' => 0,
            'level_name' => 'DEBUG',
            'context' => array(
                'user' => 'x@x.com',
            ),
            'extra' => array(
                'call' => '/api'
            ),
        )));
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('2014-01-01 11:11:11 => DEBUG => my test message' . PHP_EOL 
            . 'array (' . PHP_EOL . 
                '  \'user\' => \'x@x.com\',' . PHP_EOL
            . ')' . PHP_EOL
            . 'array (' . PHP_EOL
            . '  \'call\' => \'/api\',' . PHP_EOL
            . ')' . PHP_EOL
            , $content);
    }
}