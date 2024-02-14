<?php

namespace Felix\Incuba\Sources;

trait AlwaysCrawled
{
    public static function defaultBoundaries(): array
    {
        return [];
    }

    public static function crawlFrequency(): int
    {
        return 0;
    }
}
