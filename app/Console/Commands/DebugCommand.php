<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DebugCommand extends Command
{
    protected $signature = 'dd';

    protected $description = 'debug';

    public function handle(): void
    {
        dd(1);
    }
}
