<?php

namespace Felix\Incuba\Sources;

use Felix\Incuba\NullCache;
use Generator;
use Psr\SimpleCache\CacheInterface;

abstract class Source
{
    private static ?CacheInterface $cache = null;

    private static string $projectName = 'incuba';

    protected string $name;

    protected string $description;

    public static function withProjectName(string $name): void
    {
        self::$projectName = $name;
    }

    /** @return class-string<Source>[] */
    abstract public static function children(): array;

    public static function withCache(CacheInterface $cache, bool $force = false): void
    {
        if (! $force && self::$cache) {
            return;
        }

        self::$cache = $cache;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function urn(): string
    {
        $urn = 'urn:'.(self::$projectName).':source:';

        $source = $this;

        while ($source) {
            $urn .= $source::id().':';
            $source = $source::parent();
        }

        return rtrim($urn, ':');
    }

    abstract public static function id(): string;

    /** @return class-string<Source>|null */
    abstract public static function parent(): ?string;

    /** @return Generator<array, array> */
    abstract public function crawl(array $boundaries, ?array $parent = null): Generator;

    abstract public function defaultBoundaries(): array;

    protected function cache(): CacheInterface
    {
        if (self::$cache) {
            return self::$cache;
        }

        return new NullCache();
    }
}
