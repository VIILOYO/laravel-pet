<?php

namespace App\Queue;

use App\Queue\Interfaces\Job;
use App\Queue\Interfaces\ShouldQueue;
use Illuminate\Support\Facades\App;

class Dispatcher
{
    public function __construct(protected Queue $queue) {}

    public function dispatch(Job $job): void
    {
        if ($job instanceof ShouldQueue) {
            $this->dispatchToQueue($job);
        } else {
            $this->dispatchSync($job);
        }
    }

    public function dispatchSync(Job $job): void
    {
        App::call([$job, 'handle']);
    }

    public function dispatchToQueue(Job $job, ?int $attempts = 0): void
    {
        $this->queue->enqueue($job);
    }

    public function getQueue(): Queue
    {
        return $this->queue;
    }
}
