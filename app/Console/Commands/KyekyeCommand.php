<?php

namespace App\Console\Commands;

use App\Queue\Dispatcher;
use App\Queue\Queue;
use Illuminate\Console\Command;
use Throwable;

class KyekyeCommand extends Command
{
    protected $signature = 'kyekye:work';

    protected $description = 'Запуск кастомной очереди';

    /**
     * @throws Throwable
     */
    public function handle(): void
    {
        $dispatcher = new Dispatcher(new Queue);

        $queue = $dispatcher->getQueue();

        /**
         * @phpstan-ignore-next-line
         */
        while (true) {
            sleep(1);
            if ($queue->isEmpty()) {
                continue;
            }

            $dbJob = $queue->dequeue();

            try {
                $queue->deleteJob($dbJob);
                $dispatcher->dispatchSync($dbJob->job);
                $dispatcher->forgetUniqueJobCache($dbJob->job);
            } catch (Throwable $e) {
                sleep(1);
                $attempts = method_exists($dbJob->job, 'tries') ?
                    $dbJob->job->tries() : config('queue.jobes.attempts');
                if ($dbJob->attempts > $attempts) {
                    $queue->failed($dbJob->job, $e);
                } else {
                    $dispatcher->dispatchToQueue($dbJob->job, ++$dbJob->attempts);
                }
            }
        }
    }
}
