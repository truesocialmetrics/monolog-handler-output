<?php
namespace TweeMonolog\Handler;
use PHPUnit_Framework_TestCase;
use Monolog\Handler\NullHandler;
use Monolog\Handler\TestHandler;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Formatter\JsonFormatter;
use Monolog\Logger;

class ExceptionCatchTest extends PHPUnit_Framework_TestCase
{
    public function __construct()
    {
        $null = new NullHandler();
        $handler = new ExceptionCatch($null);
        $this->assertEquals($null, $handler->getHandler());
    }

    public function testIsHandling()
    {
        $null = new NullHandler(Logger::CRITICAL);
        $handler = new ExceptionCatch($null);
        $this->assertFalse($handler->isHandling(array('level' => Logger::DEBUG)));
        $this->assertTrue($handler->isHandling(array('level' => Logger::CRITICAL)));
    }

    public function testHandle()
    {
        $null = new NullHandler(Logger::CRITICAL);
        $handler = new ExceptionCatch($null);
        $this->assertFalse($handler->handle(array('level' => Logger::DEBUG)));
        $this->assertTrue($handler->handle(array('level' => Logger::CRITICAL)));
    }

    public function testHandleBatch()
    {
        $null = new TestHandler(Logger::CRITICAL);
        $handler = new ExceptionCatch($null);
        $handler->handleBatch(array(
            array('level' => Logger::DEBUG, 'extra' => array(), 'message' => ''),
            array('level' => Logger::CRITICAL, 'extra' => array(), 'message' => ''),
        ));
        $this->assertFalse($null->hasDebug(array('message' => '')));
        $this->assertTrue($null->hasCritical(array('message' => '')));
    }

    public function testPushPopProcessor()
    {
        $processor = new MemoryUsageProcessor();
        $handler = new ExceptionCatch(new NullHandler());
        $handler->pushProcessor($processor);
        $this->assertEquals($processor, $handler->popProcessor());
    }

    public function testSetGetFormatter()
    {
        $formatter = new JsonFormatter();
        $handler = new ExceptionCatch(new NullHandler());
        $handler->setFormatter($formatter);
        $this->assertEquals($formatter, $handler->getFormatter());
    }
}