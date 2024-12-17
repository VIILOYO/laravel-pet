<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

class ScheduleHandler
{
    public function __invoke(Schedule $schedule): void
    {
        // Тут прописываются команды
        // $schedule->command(TestCommand::class)->hourly();
    }
}
