<?php

namespace App\Queue\TestJobes;

use App\Queue\Interfaces\Job;
use App\Queue\Interfaces\ShouldQueue;

class CoolTestJob implements Job, ShouldQueue
{
    public function handle(): void
    {
        throw new \Exception('test');
    }

    public function tries(): int
    {
        return 4;
    }
}
