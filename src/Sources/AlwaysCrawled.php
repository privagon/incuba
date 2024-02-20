<?php

namespace Felix\Incuba\Sources;

trait AlwaysCrawled
{
    public function defaultBoundaries(): array
    {
        return [];
    }

    public function crawlFrequency(): int
    {
        return 0;
    }
}
