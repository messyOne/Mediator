<?php

use messyOne\EventDataInterface;
use messyOne\Mediator;

/**
 * Test the Event Mediator logic
 */
class MediatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test attaching events and trigger them
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
