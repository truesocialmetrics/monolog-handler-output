<?php
namespace TweeMonolog\Handler;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class ConsoleOutputTest extends TestCase
{
    public function test()
    {
        $handler = new ConsoleOutput();
        $method = new ReflectionMethod($handler, 'write');
        $method->setAccessible(true);
        ob_start();
        //$handler->write(array('email' => 'x@x.com'));
        $method->invokeArgs($handler, array('record' => array(
            'formatted' => '[2014-04-16 07:35:19] default.DEBUG: 2014-03-31 [] []',
        )));
        $content = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('[2014-04-16 07:35:19] default.DEBUG: 2014-03-31 [] []', $content);
    }
}
