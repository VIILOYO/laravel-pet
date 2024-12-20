<?php

namespace App\Queue;

use App\Queue\Interfaces\Job;
use App\Queue\Interfaces\QueueInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use stdClass;
use Throwable;
use UnderflowException;

class Queue implements QueueInterface
{
    public function enqueue(Job $job): void
    {
        DB::table(config('queue.jobes.table'))->insert([
            'payload' => (string) json_encode($this->getPayload($job)),
            'created_at' => Carbon::now()->timestamp,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function dequeue(): stdClass
    {
        throw_if($this->isEmpty(), UnderflowException::class);

        $job = $this->head();
        DB::table(config('queue.jobes.table'))->delete($job->id);

        return $job;
    }

    /**
     * @throws Throwable
     */
    public function head(): stdClass
    {
        throw_if($this->isEmpty(), UnderflowException::class);

        return DB::table(config('queue.jobes.table'))->orderBy('id')->first();
    }

    /**
     * @throws Throwable
     */
    public function tail(): stdClass
    {
        throw_if($this->isEmpty(), UnderflowException::class);

        return DB::table(config('queue.jobes.table'))->orderByDesc('id')->first();
    }

    public function isEmpty(): bool
    {
        return $this->size() === 0;
    }

    public function size(): int
    {
        return DB::table(config('queue.jobes.table'))->count();
    }

    /**
     * @return array<string, string|string[]>
     */
    protected function getPayload(Job $job): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'displayName' => $job::class,
            'job' => 'Illuminate\Queue\CallQueuedHandler@call',
            'data' => [
                'commandName' => $job::class,
                'command' => serialize(clone $job),
            ],
        ];
    }
}
