<?php

namespace Felix\Incuba\Utils;

use Psr\EventDispatcher\EventDispatcherInterface;

class NullDispatcher implements EventDispatcherInterface
{

    public function dispatch(object $event)
    {
        // no-op
    }
}
