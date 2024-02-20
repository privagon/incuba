<?php

namespace Felix\Incuba\Events;

use Felix\Incuba\Document;

final class DocumentCrawledEvent
{
    public function __construct(public Document $document)
    {
    }
}
