<?php

namespace Felix\Incuba\Pipeline;

use Felix\Incuba\Contracts\CopulaInterface;
use Felix\Incuba\Document;
use InvalidArgumentException;

class DisjoinedPipeline
{
    public array $outcomes = [];

    public ?Pipeline $defaultOutcome = null;

    public function __construct(protected Pipeline $pipeline, protected CopulaInterface $copula, protected array $predicates = [])
    {
    }

    public function match(string $predicate, callable $callback): self
    {
        if (!in_array($predicate, $this->predicates)) {
            throw new InvalidArgumentException("Predicate $predicate not found");
        }

        $pipeline = new Pipeline();
        $callback($pipeline);

        $this->outcomes[$predicate] = $pipeline;

        unset($this->predicates[$predicate]);

        return $this;
    }

    public function matchOthers(callable $callback): self
    {
        $this->defaultOutcome = $callback(new Pipeline());

        return $this;
    }

    public function parent(): Pipeline
    {
        return $this->pipeline;
    }

    public function route(Document $document)
    {
        $predicate = $this->copula->getPredicate($document);

        if (isset($this->outcomes[$predicate])) {
            return $this->outcomes[$predicate]->run($document);
        }

        if ($this->defaultOutcome) {
            return $this->defaultOutcome->run($document);
        }

        return $document;

    }

    public function run(Document $document)
    {
        // For convenience.
        return $this->pipeline->run($document);
    }

}
