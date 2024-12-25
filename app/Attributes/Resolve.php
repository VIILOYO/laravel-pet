<?php

namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final readonly class Resolve
{
    public function __construct(
        public string $key,
        public string $resolver
    ) {}
}
