<?php

namespace Felix\Incuba;

use Felix\Incuba\Sources\Source;
use SplStack;

class MemoryStore implements Contracts\StoreInterface
{
    public array $urnToBoundaries = [];

    /** @var SplStack<array{Source, mixed[], mixed[]}> */
    public SplStack $docs;

    public function __construct()
    {
        $this->docs = new SplStack();
    }

    public function boundariesForUrn(string $urn): ?array
    {
        return $this->urnToBoundaries[$urn] ?? null;
    }

    public function storeDoc(Source $source, array $doc, array $offset): self
    {
        $this->docs->push([$source, $doc, $offset]);

        return $this;
    }

    public function updateBoundaries(string $urn, array $boundaries): self
    {
        $this->urnToBoundaries[$urn] = $boundaries;

        return $this;
    }
}
