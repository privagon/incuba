<?php

namespace Felix\Incuba\Sources;

trait WithStaticAncestry
{
    public static function id(): string
    {
        return static::$id;
    }

    public static function parent(): ?string
    {
        return static::$parent;
    }

    public static function children(): array
    {
        return static::$children;
    }
}
