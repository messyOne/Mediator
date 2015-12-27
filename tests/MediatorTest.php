<?php

use messyOne\EventDataInterface;
use messyOne\Mediator;

/**
 * Test the Event Mediator logic
 */
class MediatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test attaching an event and trigger it
     */
    public function testAttachAndTriggerEvent()
    {
        $mediator = new Mediator();
        $testEvent = '';
        $testData = null;

        $mediator->attach('test:event', function ($event, EventDataInterface $data) use (&$testEvent, &$testData) {
            $testEvent = $event;
            $testData = $data;
        });

        $data = $this->getMockForAbstractClass(EventDataInterface::class);

        /** @var EventDataInterface $data */
        $mediator->trigger('test:event', $data);

        $this->assertEquals('test:event', $testEvent);
        $this->assertEquals($data, $testData);
    }

    /**
     * Test attaching multiple events and trigger them
     */
    public function testAttachEventsAndTriggerEvent()
    {
        $mediator = new Mediator();
        $testEvent = '';
        $testData = null;

        $mediator->attachMultiple(['test:event1', 'test:event2'], function ($event, EventDataInterface $data) use (&$testEvent, &$testData) {
            $testEvent = $event;
            $testData = $data;
        });

        $data = $this->getMockForAbstractClass(EventDataInterface::class);

        /** @var EventDataInterface $data */
        $mediator->trigger('test:event1', $data);

        $this->assertEquals('test:event1', $testEvent);
        $this->assertEquals($data, $testData);

        /** @var EventDataInterface $data */
        $mediator->trigger('test:event2', $data);

        $this->assertEquals('test:event2', $testEvent);
        $this->assertEquals($data, $testData);
    }

    /**
     * Test getting attached events array
     */
    public function testGetEvents()
    {
        $mediator = new Mediator();

        $mediator->attach('event1', function () {
        });
        $mediator->attach('event1', function () {
        });
        $mediator->attach('event2', function () {
        });
        $mediator->attach('event3', function () {
        });

        $this->assertEquals([
            'event1' => [
                function () {
                },
                function () {
                },
            ],
            'event2' => [
                function () {
                },
            ],
            'event3' => [
                function () {
                },
            ],
        ], $mediator::getEvents());
    }

    /**
     * Test reset method
     */
    public function testReset()
    {
        $mediator = new Mediator();

        $mediator->attach('event1', function () {
        });

        Mediator::reset();

        $this->assertEmpty(Mediator::getEvents());
    }

    /**
     * @inheritdoc
     */
    protected function tearDown()
    {
        parent::tearDown();

        Mediator::reset();
    }
}
