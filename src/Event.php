<?php

namespace benvens\Event;

use benvens\Event\Interfaces\EventInterface;

/**
 * Representation of an event
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package benvens\Event
 */
class Event implements EventInterface
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var null|string|object
     */
    private $target;

    /**
     * @var array
     */
    private $params;

    /**
     * @var bool
     */
    private $flag;

    /**
     * Event constructor.
     * @param string $name event name
     * @param null $target target/context from which event was triggered
     * @param array $params parameters passed to the event
     * @param bool $flag Indicate whether or not to stop propagating this event
     */
    public function __construct(
        string $name,
        $target = null,
        array $params = [],
        $flag = false
    ) {
        $this->name = $name;
        $this->target = $target;
        $this->params = $params;
        $this->flag = $flag;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @inheritdoc
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @inheritdoc
     */
    public function getParam($name)
    {
        return $this->params[$name] ?? null;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * @inheritdoc
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @inheritdoc
     */
    public function stopPropagation($flag)
    {
        $this->flag = $flag;
    }

    /**
     * @inheritdoc
     */
    public function isPropagationStopped()
    {
        return $this->flag;
    }
}
