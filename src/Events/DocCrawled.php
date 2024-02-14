<?php

namespace Felix\Incuba\Events;

use Felix\Incuba\Sources\Source;

class DocCrawled
{
    public function __construct(
        public Source $source,
        public array  $doc,
        public array  $offset,
    ) {
    }
}
