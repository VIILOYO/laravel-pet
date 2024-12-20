<?php

namespace App\Domain\Dto\Misc;

use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Data;

class PaginationData extends Data
{
    public function __construct(
        #[Min(1)]
        #[Nullable]
        public int $page = 1,
        #[Min(1)]
        #[Nullable]
        public int $per_page = 10,
    ) {}
}
