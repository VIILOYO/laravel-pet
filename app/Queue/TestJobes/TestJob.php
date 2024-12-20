<?php

namespace App\Queue\TestJobes;

use App\Queue\Interfaces\Job;
use App\Queue\Interfaces\ShouldQueue;

class TestJob implements Job, ShouldQueue
{
    public function __construct(
        public string $name,
        public string $surname,
    ) {}

    public function handle(): void
    {
        dump('Тут я что-то делаю');
    }
}
