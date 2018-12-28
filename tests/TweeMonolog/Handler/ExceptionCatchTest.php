<?php
namespace TweeMonolog\Handler;
use PHPUnit\Framework\TestCase;
use Monolog\Handler\NullHandler;
use Monolog\Handler\TestHandler;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Formatter\JsonFormatter;
use Monolog\Logger;

class ExceptionCatchTest extends TestCase
{
    public function testConstruct()
    {
        $null = new NullHandler();
        $handler = new ExceptionCatch($null);
        $this->assertEquals($null, $handler->getHandler());
    }

    public function testIsHandling()
    {
        $null = new NullHandler(Logger::CRITICAL);
        $handler = new ExceptionCatch($null);
        $this->assertFalse($handler->isHandling(['level' => Logger::DEBUG]));
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
            array('level' => Logger::DEBUG, 'extra' => array(), 'message' => '', 'context' => []),
            array('level' => Logger::CRITICAL, 'extra' => array(), 'message' => '', 'context' => []),
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

    public function testCall()
    {
        $null = new TestHandler(Logger::CRITICAL);
        $handler = new ExceptionCatch($null);
        $handler->handleBatch(array(
            array('level' => Logger::DEBUG, 'extra' => array(), 'message' => '', 'context' => []),
            array('level' => Logger::CRITICAL, 'extra' => array(), 'message' => '', 'context' => []),
        ));
        $this->assertFalse($handler->hasDebug(array('message' => '')));
        $this->assertTrue($handler->hasCritical(array('message' => '')));
    }
}
