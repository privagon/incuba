<?php

namespace Felix\Incuba\Sources;

trait WithStaticAncestry
{
    public function id(): string
    {
        return static::$id;
    }

    public function parent(): ?string
    {
        return static::$parent;
    }

    public function children(): array
    {
        return static::$children;
    }
}
