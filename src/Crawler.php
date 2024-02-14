<?php

namespace Felix\Incuba;

use DateTime;
use DateTimeInterface;
use Felix\Incuba\Events\DocCrawled;
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
    /** @var callable(): DateTimeInterface */
    private $timeSource;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct()
    {
        $this->defaultCache = new NullCache();
        $this->eventDispatcher = new NullDispatcher();
        $this->timeSource = fn() => new DateTime();
    }

    public function crawl(Source $source, ?array $boundaries = null): DateTimeInterface
    {
        $boundaries ??= $source->defaultBoundaries();

        $source->withCache($this->defaultCache, force: false);

        foreach ($source->crawl($boundaries, $this->parent) as $offset => $doc) {
            $this->eventDispatcher->dispatch(new DocCrawled($source, $doc, $offset));
        }

        return new DateTime();
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

    public function withEventDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->eventDispatcher = $dispatcher;
        return $this;
    }

    public function withTimeSource(callable $timeSource): self
    {
        $this->timeSource = $timeSource;

        return $this;
    }
}
