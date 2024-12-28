<?php

namespace App\Queue;

use App\Queue\Interfaces\Job;
use App\Queue\Interfaces\ShouldBeUnique;
use App\Queue\Interfaces\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class Dispatcher
{
    public function __construct(protected Queue $queue) {}

    public function dispatch(Job $job): void
    {
        if ($this->checkUnique($job)) {
            $job instanceof ShouldQueue ?
                $this->dispatchToQueue($job) :
                $this->dispatchSync($job);
        }
    }

    public function dispatchSync(Job $job): void
    {
        App::call([$job, 'handle']);
    }

    public function dispatchToQueue(Job $job, ?int $attempts = 0): void
    {
        $this->queue->enqueue($job, $attempts);
    }

    public function getQueue(): Queue
    {
        return $this->queue;
    }

    private function checkUnique(Job $job): bool
    {
        if ($job instanceof ShouldBeUnique) {
            $exist = Cache::has(config('queue.jobes.unique-prefix').'-'.get_class($job));

            if (! $exist) {
                Cache::put(config('queue.jobes.unique-prefix').'-'.get_class($job), '');
            }

            return true;
        }

        return false;
    }
}
