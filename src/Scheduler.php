<?php

namespace Felix\Incuba;

use DateTimeInterface;
use Felix\Incuba\Sources\Source;

class Scheduler
{
    public function __construct(
        protected Crawler            $crawler,
        protected Source             $source,
        protected ?DateTimeInterface $lastCrawl = null,
    )
    {
    }

    public function run(
        DateTimeInterface $now,
    )
    {
        if (
            $this->lastCrawl === null || // first crawl?
            ($now->getTimestamp() - $this->lastCrawl->getTimestamp()) > $this->source->crawlFrequency() // recrawl?
        ) {
            $this->crawler->crawl($this->source);
        }
    }
}
