<?php

namespace Tests;

use benliev\Event\Event;
use benliev\Event\EventManager;
use benliev\Event\Interfaces\EventInterface;
use benliev\Event\Interfaces\EventManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class EventManagerTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class EventManagerTest extends TestCase
{

    /**
     * @var EventManagerInterface
     */
    private $manager;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->manager = new EventManager();
    }

    /**
     * Make an event
     * @param string $name
     * @return Event
     */
    public function makeEvent(string $name = 'default.index')
    {
        return new Event($name);
    }

    /**
     * @covers EventManager::attach()
     * @covers EventManager::trigger()
     */
    public function testTriggerEventWithEventObject()
    {
        $event = $this->makeEvent();
        $this->manager->attach($event->getName(), function (EventInterface $e) {
            echo $e->getName();
        });
        $this->expectOutputString($event->getName());
        $this->manager->trigger($this->makeEvent());
    }

    /**
     * Test trigger event with not event, trigger method created it
     * @covers EventManager::attach()
     * @covers EventManager::trigger()
     */
    public function testTriggerEventWithoutEventObject()
    {
        $this->manager->attach('default.index', function () {
            echo 'demo';
        });
        $this->expectOutputString('demo');
        $this->manager->trigger('default.index');
    }

    /**
     * @covers EventManager::attach()
     * @covers EventManager::trigger()
     */
    public function testTriggerMultipleEvent()
    {
        $event = $this->makeEvent();
        $this->manager->attach($event->getName(), function () {
            echo '1';
        });
        $this->manager->attach($event->getName(), function () {
            echo '2';
        });
        $this->expectOutputString('12');
        $this->manager->trigger($this->makeEvent());
    }

    /**
     * @covers EventManager::attach()
     * @covers EventManager::trigger()
     */
    public function testTriggerOrderWithPriority()
    {
        $event = $this->makeEvent();
        $this->manager->attach($event->getName(), function () {
            echo '1';
        }, 1);
        $this->manager->attach($event->getName(), function () {
            echo '3';
        }, 3);
        $this->manager->attach($event->getName(), function () {
            echo '2';
        }, 2);
        $this->expectOutputString('123');
        $this->manager->trigger($this->makeEvent());
    }

    /**
     * @covers EventManager::attach()
     * @covers EventManager::detach()
     */
    public function testDetachListener()
    {
        $event = $this->makeEvent();
        $callback = function () {
        };
        $this->manager->attach($event->getName(), $callback);
        $this->assertTrue($this->manager->detach($event->getName(), $callback));
    }

    /**
     * @covers EventManager::attach()
     * @covers EventManager::clearListeners()
     * @covers EventManager::trigger()
     */
    public function testClearListeners()
    {
        $event = $this->makeEvent();
        $event2 = $this->makeEvent('event.post');
        $this->manager->attach($event->getName(), function () {
            echo '1';
        });
        $this->manager->attach($event2->getName(), function () {
            echo '2';
        });
        $this->manager->clearListeners($event2->getName());
        $this->expectOutputString(null);
        $this->manager->trigger($event2);
        $this->expectOutputString('1');
        $this->manager->trigger($event);
    }

    /**
     * @covers EventManager::attach()
     * @covers EventManager::trigger()
     */
    public function testTriggerWithStopPropagation()
    {
        $event = $this->makeEvent();
        $this->manager->attach($event->getName(), function () {
            echo '1';
        });
        $this->manager->attach($event->getName(), function (EventInterface $event) {
            $event->stopPropagation(true);
        });
        $this->manager->attach($event->getName(), function () {
            echo '3';
        });
        $this->expectOutputString('1');
        $this->manager->trigger($event);
    }

    /**
     * @covers EventManager::detach()
     */
    public function testDetachUnknowEvent()
    {
        $this->assertFalse($this->manager->detach('toto', function () {
        }));
    }

    /**
     * @covers EventManager::attach()
     * @covers EventManager::detach()
     */
    public function testDetachUnknowCallback()
    {
        $event = $this->makeEvent();
        $this->manager->attach($event->getName(), function () {
            echo '1';
        });
        $this->assertFalse($this->manager->detach($event->getName(), function () {
        }));
    }
}
