<?php

namespace Mimachh\Cacheable\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Cacheable
{
    public function __construct(
        public int $ttl,
        public string $key
    ) {}
}
