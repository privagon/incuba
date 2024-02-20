<?php

namespace Felix\Incuba\Events;

use Felix\Incuba\Document;
use Felix\Incuba\Pipeline\Pipeline;

final class DocumentProcessedEvent
{
    public function __construct(public Pipeline $pipeline, public Document $document)
    {
    }
}
