<?php

namespace Felix\Incuba\Contracts;

use Felix\Incuba\Document;
use Stringable;

interface CopulaInterface
{
    public const IGNORED = '_ignored';
    public const INVALID = '_invalid';
    public const UNKNOWN = '_unknown';

    public function getPredicate(Document $document): string;

    /** @return string[] */
    public function predicates(): array;
}
