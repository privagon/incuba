<?php

namespace Felix\Incuba\Pipeline;

use Felix\Incuba\Document;

class TouchOperation
{

    /** @var callable */
    private $callback;

    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    public function __invoke(Document $document)
    {
        $clone = clone $document;

        ($this->callback)($clone);
    }
}
