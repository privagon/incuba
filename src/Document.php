<?php

namespace Felix\Incuba;

use Felix\Incuba\Sources\Source;

class Document
{
    public array $annotations = [];

    private array $copy;

    public function __construct(
        public Source $source,
        public array  $doc,
        public array  $offset,
    )
    {
        $this->copy = $doc;
    }


    public function transform(string $key, mixed $value): self
    {
        $this->doc[$key] = $value;

        return $this;
    }

    public function getTransformed(string $key): mixed
    {
        return $this->doc[$key];
    }
}
