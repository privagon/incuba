<?php

namespace Felix\Incuba\Pipeline;

use Felix\Incuba\Contracts\CopulaInterface;
use Felix\Incuba\Document;

class Pipeline
{
    public array $operations = [];

    public ?DisjoinedPipeline $disjoin = null;


    public function disjoin(CopulaInterface|callable|string $copula, array $predicates = []): DisjoinedPipeline
    {
        if (class_exists($copula)) {
            $copula = new $copula;
        }

        if (is_callable($copula)) {
            $copula = new FunctionalCopula($copula, $predicates);
        }

        if (method_exists($copula, 'predicates')) {
            $predicates = $copula->predicates();
        }

        return $this->disjoin = new DisjoinedPipeline($this, $copula, $predicates);
    }

    /** @var callable|class-string $callback */
    public function annotate(callable|string $callback): self
    {
        if (is_string($callback)) {
            $callback = new $callback;
        }

        // For information derived from the doc, lives in a separate array
        $this->operations[] = new TransformOperation($callback);
        return $this;
    }

    public function transform(callable|string $callback): self
    {
        if (is_string($callback)) {
            $callback = new $callback;
        }

        // Transform changes the write-read copy of the doc (there is also a read-only immutable copy)
        $this->operations[] = new TransformOperation($callback);

        return $this;
    }

    public function run(Document $document)
    {
        foreach ($this->operations as $operation) {
            $operation($document);
        }

        if (!$this->disjoin) {
            return $document;
        }


        return $this->disjoin->route($document);
    }

    public function touch(callable|string $callback)
    {
        if (is_string($callback)) {
            $callback = new $callback;
        }

        $this->operations[] = new TouchOperation($callback);

        return $this;
    }
}
