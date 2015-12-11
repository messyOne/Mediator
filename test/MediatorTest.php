<?php
use messyOne\Mediator\Mediator;

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

        $mediator->attach('test:event', function ($event, $data) use (&$testEvent, &$testData) {
            $testEvent = $event;
            $testData = $data;
        });

        $mediator->trigger('test:event', 'foo');

        $this->assertEquals('test:event', $testEvent);
        $this->assertEquals('foo', $testData);
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
     * Test callback with multiple arguments
     */
    public function testEventCallbackWithMultipleArguments()
    {
        $mediator = new Mediator();
        $testEvent = '';
        $testData = [];

        $mediator->attach('test:event', function ($event, $param1, $param2) use (&$testEvent, &$testData) {
            $testEvent = $event;
            $testData = [
                $param1,
                $param2
            ];
        });

        $mediator->trigger('test:event', 'param1', 'param2');

        $this->assertEquals('test:event', $testEvent);
        $this->assertEquals([
            'param1',
            'param2',
        ], $testData);
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
