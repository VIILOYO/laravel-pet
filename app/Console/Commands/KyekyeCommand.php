<?php

namespace App\Console\Commands;

use App\Queue\Dispatcher;
use App\Queue\Queue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use stdClass;
use Throwable;

class KyekyeCommand extends Command
{
    protected $signature = 'kyekye:work';

    protected $description = 'Запуск кастомной очереди';

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

            $queueJob = $queue->dequeue();

            $job = unserialize(json_decode($queueJob->payload)->data->command);

            try {
                $dispatcher->dispatchSync($job);
            } catch (Throwable $e) {
                sleep(1);
                $attempts = method_exists($job, 'tries') ?
                    $job->tries() : config('queue.jobes.attempts');
                if ($queueJob->attempts > $attempts) {
                    $this->failed($queueJob, $e);
                } else {
                    $dispatcher->dispatchToQueue($job, ++$queueJob->attempts);
                }
            }
        }
    }

    public function failed(stdClass $job, Throwable $exception): void
    {
        DB::table(config('queue.jobes.failed_table'))->insert([
            'uuid' => json_decode($job->payload)->uuid,
            'queue' => config('queue.jobes.table'),
            'payload' => $job->payload,
            'exception' => $exception->getMessage(),
        ]);
    }
}
