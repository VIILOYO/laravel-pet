<?php

namespace App\Domain\Dto\Agg;

use Spatie\LaravelData\Data;

class AggData extends Data
{
    public function __construct(
        public string $name,
        public ?string $as,
        public ?string $agg,
    ) {}

    public function isAgg(): bool
    {
        return $this->agg !== null;
    }
}
