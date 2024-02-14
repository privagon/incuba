<?php

namespace Felix\Incuba\Contracts;

use Felix\Incuba\Sources\Source;

interface StoreInterface
{
    public function boundariesForUrn(string $urn): ?array;

    public function updateBoundaries(string $urn, array $boundaries): self;

    public function storeDoc(Source $source, array $doc, array $offset): self;
}
