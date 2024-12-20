<?php

namespace App\Queue\TestJobes;

use App\Queue\Interfaces\Job;
use App\Queue\Interfaces\ShouldBeUnique;
use App\Queue\Interfaces\ShouldQueue;

class UniqueJob implements Job, ShouldBeUnique, ShouldQueue
{
    public function handle(): void {}
}
