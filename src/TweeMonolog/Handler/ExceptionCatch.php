<?php
namespace TweeMonolog\Handler;
use Monolog\Handler\HandlerInterface;
use Monolog\Formatter\FormatterInterface;

class ExceptionCatch implements HandlerInterface
{
    protected $handler = null;

    public function __construct(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Checks whether the given record will be handled by this handler.
     *
     * This is mostly done for performance reasons, to avoid calling processors for nothing.
     *
     * Handlers should still check the record levels within handle(), returning false in isHandling()
     * is no guarantee that handle() will not be called, and isHandling() might not be called
     * for a given record.
     *
     * @param array $record
     *
     * @return Boolean
     */
    public function isHandling(array $record)
    {
        try {
            return $this->getHandler()->isHandling($record);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Handles a record.
     *
     * All records may be passed to this method, and the handler should discard
     * those that it does not want to handle.
     *
     * The return value of this function controls the bubbling process of the handler stack.
     * Unless the bubbling is interrupted (by returning true), the Logger class will keep on
     * calling further handlers in the stack with a given log record.
     *
     * @param  array   $record The record to handle
     * @return Boolean true means that this handler handled the record, and that bubbling is not permitted.
     *                        false means the record was either not processed or that this handler allows bubbling.
     */
    public function handle(array $record)
    {
        try {
            return $this->getHandler()->handle($record);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Handles a set of records at once.
     *
     * @param array $records The records to handle (an array of record arrays)
     */
    public function handleBatch(array $records)
    {
        try {
            return $this->getHandler()->handleBatch($records);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Adds a processor in the stack.
     *
     * @param  callable $callback
     * @return self
     */
    public function pushProcessor($callback)
    {
        try {
            return $this->getHandler()->pushProcessor($callback);
        } catch (\Exception $e) {
            return $this;
        }
    }

    /**
     * Removes the processor on top of the stack and returns it.
     *
     * @return callable
     */
    public function popProcessor()
    {
        try {
            return $this->getHandler()->popProcessor();
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Sets the formatter.
     *
     * @param  FormatterInterface $formatter
     * @return self
     */
    public function setFormatter(FormatterInterface $formatter)
    {
        try {
            return $this->getHandler()->setFormatter($formatter);
        } catch (\Exception $e) {
            return $this;
        }
    }

    /**
     * Gets the formatter.
     *
     * @return FormatterInterface
     */
    public function getFormatter()
    {
        try {
            return $this->getHandler()->getFormatter();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function __call($method, $arguments)
    {
        try {
            return call_user_func_array(array($this->getHandler(), $method), $arguments);
        } catch (\Exception $e) {}
    }
}
