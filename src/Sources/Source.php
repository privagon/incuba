<?php

namespace Felix\Incuba\Sources;

use Felix\Incuba\Utils\NullCache;
use Generator;
use Psr\SimpleCache\CacheInterface;

abstract class Source
{
    public const int SECOND = 1;

    public const int MINUTE = self::SECOND * 60;

    public const int HOUR = self::MINUTE * 60;

    public const int DAY = self::HOUR * 24;

    public const int WEEK = self::DAY * 7;

    private static ?CacheInterface $cache = null;

    private static string $projectName = 'incuba';

    protected string $name;

    protected string $description;

    public static function withProjectName(string $name): void
    {
        self::$projectName = $name;
    }

    /** @return class-string<Source>[] */
    abstract public function children(): array;

    public static function withCache(CacheInterface $cache, bool $force = false): void
    {
        if (! $force && self::$cache) {
            return;
        }

        self::$cache = $cache;
    }

    public function urn(): string
    {
        $urn = [];

        $source = static::class;

        while ($source !== null) {
            $urn[] = $source::$id;

            $source = ($source::$parent);
        }

        $urn[] = 'source';
        $urn[] = self::$projectName;
        $urn[] = 'urn';

        $urn = array_reverse($urn);

        return implode(':', $urn);
    }

    abstract public function id(): string;

    /** @return class-string<Source>|null */
    abstract public function parent(): ?string;

    abstract public function defaultBoundaries(): array;

    /**
     * @return int Crawl frequency (in seconds)
     */
    abstract public function crawlFrequency(): int;

    public function name(): string
    {
        return $this->name;
    }

    public function description(): string
    {
        return $this->description;
    }

    /** @return Generator<array, array> */
    abstract public function crawl(array $boundaries, ?array $parent = null): Generator;

    protected function cache(): CacheInterface
    {
        if (self::$cache) {
            return self::$cache;
        }

        return new NullCache();
    }
}
