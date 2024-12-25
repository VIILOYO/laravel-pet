<?php

namespace App\Queue\DTO;

use App\Queue\Interfaces\Job;
use Spatie\LaravelData\Data;

class DbJob extends Data
{
    public function __construct(
        public Job $job,
        public int $attempts,
        public int $id,
    ) {}
}
