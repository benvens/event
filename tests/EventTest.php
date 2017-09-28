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

    /**
     * @covers Event::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('demo', $this->event->getName());
    }

    /**
     * @covers Event::setName()
     */
    public function testSetName()
    {
        $this->event->setName('a');
        $this->assertEquals('a', $this->event->getName());
    }

    /**
     * @covers Event::getTarget()
     */
    public function testGetTarget()
    {
        $this->assertEquals($this, $this->event->getTarget());
    }

    public function testSetTarget()
    {
        $this->event->setTarget(null);
        $this->assertNull($this->event->getTarget());
    }

    /**
     * @covers Event::getParams()
     */
    public function testGetParams()
    {
        $this->assertEquals(['invoker'=>$this], $this->event->getParams());
    }


    /**
     * @covers Event::setParams()
     */
    public function testSetParams()
    {
        $params = ['a', 'b'];
        $this->event->setParams($params);
        $this->assertEquals($params, $this->event->getParams());
    }

    /**
     * @covers Event::getParam()
     */
    public function testGetParam()
    {
        $this->assertEquals($this, $this->event->getParam('invoker'));
    }

    /**
     * @covers Event::getParam()
     */
    public function testGetUnknowParamReturnNull()
    {
        $this->assertNull($this->testGetParam());
    }

    /**
     * @covers Event::isPropagationStopped()
     */
    public function testIsPropagationStopped()
    {
        $this->assertFalse($this->event->isPropagationStopped());
    }

    /**
     * @covers Event::stopPropagation()
     */
    public function testStopPropagation()
    {
        $this->event->stopPropagation(true);
        $this->assertTrue($this->event->isPropagationStopped());
    }
}
