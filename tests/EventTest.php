<?php

namespace Tests;

use benliev\Event\Event;
use PHPUnit\Framework\TestCase;

/**
 * Class EventTest
 * @author Lievens Benjamin <l.benjamin185@gmail.com>
 */
class EventTest extends TestCase
{
    /**
     * @var Event
     */
    private $event;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();
        $this->event = new Event('demo', $this, ['invoker'=>$this], false);
    }

    public function testGetName()
    {
        $this->assertEquals('demo', $this->event->getName());
    }

    public function testSetName()
    {
        $this->event->setName('a');
        $this->assertEquals('a', $this->event->getName());
    }

    public function testGetTarget()
    {
        $this->assertEquals($this, $this->event->getTarget());
    }

    public function testSetTarget()
    {
        $this->event->setTarget(null);
        $this->assertNull($this->event->getTarget());
    }

    public function testGetParams()
    {
        $this->assertEquals(['invoker'=>$this], $this->event->getParams());
    }


    public function testSetParams()
    {
        $params = ['a', 'b'];
        $this->event->setParams($params);
        $this->assertEquals($params, $this->event->getParams());
    }

    public function testGetParam()
    {
        $this->assertEquals($this, $this->event->getParam('invoker'));
    }

    public function testGetUnknowParamReturnNull()
    {
        $this->assertNull($this->testGetParam());
    }

    public function testIsPropagationStopped()
    {
        $this->assertFalse($this->event->isPropagationStopped());
    }

    public function testStopPropagation()
    {
        $this->event->stopPropagation(true);
        $this->assertTrue($this->event->isPropagationStopped());
    }
}
