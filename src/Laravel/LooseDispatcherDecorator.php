<?php

namespace Felix\Incuba\Laravel;

use InvalidArgumentException;
use Psr\EventDispatcher\EventDispatcherInterface;

class LooseDispatcherDecorator implements EventDispatcherInterface
{
    public function __construct(private object $dispatcher)
    {
    }

    public function dispatch(object $event)
    {
        method_exists($this->dispatcher, 'dispatch')
        || throw new InvalidArgumentException('The dispatcher must have a dispatch method');

        return $this->dispatcher->dispatch($event);
    }
}
