<?php

namespace benliev\Event;

use benliev\Event\Interfaces\EventManagerInterface;

/**
 * Class EventManager
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 * @package benliev\Event
 */
class EventManager implements EventManagerInterface
{
    /**
     * @var array
     */
    private $listeners;

    /**
     * @inheritdoc
     */
    public function attach($event, $callback, $priority = 0)
    {
        $this->listeners[$event][] = compact('callback', 'priority');
        return true;
    }

    /**
     * @inheritdoc
     */
    public function detach($event, $callback)
    {
        if (is_string($event) && is_callable($callback) && isset($this->listeners[$event])) {
            $oldCount = count($this->listeners[$event]);
            $this->listeners[$event] = array_filter(
                $this->listeners[$event],
                function ($listener) use ($callback) {
                    return $listener['callback'] !== $callback;
                }
            );
            // returns true if one or more items have been filtered
            return $oldCount > count($this->listeners[$event]);
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function clearListeners($event)
    {
        $this->listeners[$event] = [];
    }

    /**
     * @inheritdoc
     */
    public function trigger($event, $target = null, $argv = array())
    {
        if (is_string($event)) {
            $event = new Event($event, $target, $argv);
        }
        if (isset($this->listeners[$event->getName()])) {
            usort(
                $this->listeners[$event->getName()],
                function ($a, $b) {
                    return $a['priority'] <=> $b['priority'];
                }
            );
            foreach ($this->listeners[$event->getName()] as ['callback' => $callback]) {
                if ($event->isPropagationStopped()) {
                    break;
                }
                call_user_func($callback, $event);
            }
        }
        return;
    }
}
