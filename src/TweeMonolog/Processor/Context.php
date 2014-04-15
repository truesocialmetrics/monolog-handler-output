<?php
namespace TweeMonolog\Processor;

class Context
{
    protected $context = array();

    /**
     * @param mixed $context
     */
    public function __construct(array $context = array())
    {
        $this->setContext($context);
    }

    public function setContext(array $context)
    {
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        $record['extra'] = array_merge(
            $record['extra'],
            $this->context
        );
        return $record;
    }
}