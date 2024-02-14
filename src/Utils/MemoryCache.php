<?php

namespace Felix\Incuba\Utils;

use DateInterval;
use Psr\SimpleCache\CacheInterface;

class MemoryCache implements CacheInterface
{
    private array $cache = [];

    public function clear(): bool
    {
        $this->cache = [];

        return true;
    }

    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        foreach ($keys as $key) {
            // @phpstan-ignore-next-line
            yield $this->get($key, $default);
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->cache[$key] ?? $default;
    }

    public function setMultiple(iterable $values, DateInterval|int|null $ttl = null): bool
    {
        foreach ($values as $key => $value) {
            $this->set($key, $value, $ttl);
        }

        return true;
    }

    public function set(string $key, mixed $value, DateInterval|int|null $ttl = null): bool
    {
        $this->cache[$key] = $value;

        return true;
    }

    public function deleteMultiple(iterable $keys): bool
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }

        return true;
    }

    public function delete(string $key): bool
    {
        unset($this->cache[$key]);

        return true;
    }

    public function has(string $key): bool
    {
        return isset($this->cache[$key]);
    }
}
