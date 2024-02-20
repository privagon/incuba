<?php

namespace Felix\Incuba\Pipeline;

use Felix\Incuba\Document;

class TransformOperation
{
    private $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function __invoke(Document $document)
    {
        ($this->callback)($document);
    }
}
