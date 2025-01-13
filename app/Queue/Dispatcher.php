<?php

namespace App\Queue;

use App\Queue\Interfaces\Job;
use App\Queue\Interfaces\ShouldBeUnique;
use App\Queue\Interfaces\ShouldQueue;
use Illuminate\Support\Carbon;
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

    public function forgetUniqueJobCache(Job $job): void
    {
        if ($job instanceof ShouldBeUnique) {
            Cache::forget($this->getJobUniqueName($job));
        }
    }

    private function checkUnique(Job $job): bool
    {
        if ($job instanceof ShouldBeUnique) {
            $exist = Cache::has($this->getJobUniqueName($job));

            if (! $exist) {
                Cache::put(
                    $this->getJobUniqueName($job),
                    '',
                    Carbon::now()->addSeconds($job->uniqueFor ?? config('queue.jobes.unique_for_default'))
                );

                return true;
            } else {
                return false;
            }
        }

        return true;
    }

    private function getJobUniqueName(Job $job): string
    {
        $uniqueId = method_exists($job, 'uniqueId') ? $job->uniqueId() : null;

        return config('queue.jobes.unique-prefix').'-'.get_class($job).'-'.$uniqueId;
    }
}
