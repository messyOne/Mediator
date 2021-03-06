<?php

namespace messyOne;

use Closure;
use InvalidArgumentException;

/**
 * Delegates the events to the attaches listener
 */
class Mediator
{
    /** @var Closure[] */
    private static $events = [];

    /**
     * @param string  $event
     * @param Closure $callback
     */
    public function attach($event, Closure $callback)
    {
        if (!is_string($event)) {
            throw new InvalidArgumentException();
        }

        $event = $this->parseEvent($event);

        if (!isset(self::$events[$event])) {
            self::$events[$event] = [];
        }

        self::$events[$event][] = $callback;
    }

    /**
     * @param array $events
     * @param Closure $callback
     */
    public function attachMultiple(array $events, Closure $callback)
    {
        foreach ($events as $event) {
            $this->attach($event, $callback);
        }
    }

    /**
     * @param string    $event
     * @param EventDataInterface $data
     * @return bool
     */
    public function trigger($event, EventDataInterface $data)
    {
        if (!is_string($event)) {
            throw new InvalidArgumentException();
        }

        $event = $this->parseEvent($event);

        if (!isset(self::$events[$event])) {
            return false;
        }

        foreach (self::$events[$event] as $callback) {
            $callback($data, $event);
        }

        return true;
    }

    /**
     * @return Closure[]
     */
    public static function getEvents()
    {
        return self::$events;
    }

    /**
     * Delete all attached events
     */
    public static function reset()
    {
        self::$events = [];
    }

    /**
     * @param string $event
     * @return string
     */
    private function parseEvent($event)
    {
        return strtolower(trim($event));
    }
}
