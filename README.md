[![Build Status](https://travis-ci.org/messyOne/Mediator.svg?branch=master)](https://travis-ci.org/messyOne/Mediator)

# Mediator
Simple event mediator for PHP. Use it if you need a centralized place to handle your events. 

## How to use
### Normal usage
```
   // create an instance
   $mediator = new Mediator();
   
   // attach an event
   $mediator->attach('unique:event', function ($event, $param1, $params2) {
      // do whatever need to do
   });
   
   // somewhere else in the code you can trigger the event and send the data to the callback function
   $mediator->trigger('unique:event', 'value_for_param1', 'value_for_params2');
   
```
### Additional information
Since the events are saved in a static variable you might need to delete them (for instance for unit tests).
```
    Mediator::reset();
```
