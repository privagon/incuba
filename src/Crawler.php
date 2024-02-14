<?php

namespace Felix\Incuba;

use Felix\Incuba\Contracts\StoreInterface;
use Felix\Incuba\Sources\Source;
use Psr\SimpleCache\CacheInterface;

class Crawler
{
    /** @var Source[] */
    protected array $sources;

    protected StoreInterface $store;

    protected ?array $parent = null;

    private CacheInterface $defaultCache;

    public function __construct()
    {
        $this->defaultCache = new NullCache();
    }

    public function crawl(): self
    {
        foreach ($this->sources as $source) {
            $source->withCache($this->defaultCache, force: false);

            $boundaries = $this->store->boundariesForUrn($source->urn()) ?? $source->defaultBoundaries();

            foreach ($source->crawl($boundaries, $this->parent) as $offset => $doc) {
                $this->store->storeDoc($source, $doc, $offset);

                (new self)
                    ->withStore($this->store)
                    ->withParent($doc)
                    ->withSources($source->children())
                    ->crawl();
            }

            if (isset($offset)) {
                $this->store->updateBoundaries($source->urn(), $offset);
            }
        }

        return $this;
    }

    public function withCache(CacheInterface $cache): self
    {
        $this->defaultCache = $cache;

        return $this;
    }

    public function withSources(Source|array ...$sources): self
    {
        if (count($sources) === 1 && is_array($sources[0])) {
            $sources = $sources[0];
        }

        $this->sources = $sources;

        return $this;
    }

    public function withParent(array $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function withStore(StoreInterface $store): self
    {
        $this->store = $store;

        return $this;
    }
}
