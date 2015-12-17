[![Build Status](https://travis-ci.org/messyOne/mediator.svg?branch=master)](https://travis-ci.org/messyOne/Mediator)

# Mediator
Simple event mediator for PHP. Use it if you need a centralized place to handle your events. 

## How to use
### Normal usage
```
   // create an instance
   $mediator = new Mediator();
   
   // create an class implementing the EventData interface
   class ConcreteEventData implements EventData
   {
       /** @var string */
       private $foo;
   
       /**
        * @param string $foo
        */
       public function __construct($foo)
       {
           $this->foo = $foo;
       }
   
       /**
        * @return string
        */
       public function getFoo()
       {
           return $this->foo;
       }
   }

   
   // attach an event
   $mediator->attach('unique:event', function ($event, ConcreteEventData $data) {
      // do whatever you have to do with $data->getFoo()
   });
   
   // somewhere else in the code you can trigger the event and send the data to the callback function
   $mediator->trigger('unique:event', new ConcreteEventData('foo'));
   
```
### Additional information
Since the events are saved in a static variable you might need to delete them (for instance for unit tests).
```
    Mediator::reset();
```
