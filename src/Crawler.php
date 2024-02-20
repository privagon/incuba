<?php

namespace Felix\Incuba;

use Felix\Incuba\Events\DocumentCrawledEvent;
use Felix\Incuba\Events\DocumentProcessedEvent;
use Felix\Incuba\Pipeline\DisjoinedPipeline;
use Felix\Incuba\Pipeline\Pipeline;
use Felix\Incuba\Sources\Source;
use Felix\Incuba\Utils\NullCache;
use Felix\Incuba\Utils\NullDispatcher;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\SimpleCache\CacheInterface;

class Crawler
{
    protected Source $source;

    protected ?array $parent = null;

    protected CacheInterface $defaultCache;
    private EventDispatcherInterface $eventDispatcher;
    /** @var Pipeline[] */
    private array $pipelines = [];

    public function __construct()
    {
        $this->defaultCache = new NullCache();
        $this->eventDispatcher = new NullDispatcher();
    }

    public function crawl(Source $source, ?array $boundaries = null)
    {
        $boundaries ??= $source->defaultBoundaries();

        $source->withCache($this->defaultCache, force: false);

        foreach ($source->crawl($boundaries, $this->parent) as $offset => $doc) {
            $document = new Document($source, $doc, $offset);

            $this->eventDispatcher->dispatch(new DocumentCrawledEvent($document));

            foreach ($this->pipelines as $pipeline) {
                $processed = $pipeline->run($document);

                $this->eventDispatcher->dispatch(new DocumentProcessedEvent($pipeline, $processed));
            }
        }
    }

    public function withCache(CacheInterface $cache): self
    {
        $this->defaultCache = $cache;

        return $this;
    }

    public function withParent(array $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function withEventDispatcher(EventDispatcherInterface $dispatcher): self
    {
        $this->eventDispatcher = $dispatcher;

        return $this;
    }

    public function withPipelines(Pipeline|DisjoinedPipeline ...$pipelines): self
    {
        $this->pipelines = $pipelines;

        return $this;
    }
}
