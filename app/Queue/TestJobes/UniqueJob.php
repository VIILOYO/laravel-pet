<?php

namespace App\Queue\TestJobes;

use App\Queue\Interfaces\Job;
use App\Queue\Interfaces\ShouldBeUnique;
use App\Queue\Interfaces\ShouldQueue;

class UniqueJob implements Job, ShouldBeUnique, ShouldQueue
{
    public int $uniqueFor = 3600;

    public function uniqueId(): int|string
    {
        return 1;
    }

    public function handle(): void {
        dump('Уникальная джоба ура');
    }
}
