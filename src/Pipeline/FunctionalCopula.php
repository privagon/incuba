<?php

namespace Felix\Incuba\Pipeline;

use Felix\Incuba\Contracts\CopulaInterface;
use Felix\Incuba\Document;

class FunctionalCopula implements CopulaInterface
{
    /** @var callable */
    private $predication;

    public function __construct(
        callable        $predication,
        protected array $predicates,
    )
    {
        $this->predication = $predication;
    }

    public function getPredicate(Document $document): string
    {
        return ($this->predication)($document);
    }

    public function predicates(): array
    {
        return $this->predicates;
    }

}
