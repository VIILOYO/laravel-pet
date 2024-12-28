<?php

namespace App\Queue;

use App\Queue\DTO\DbJob;
use App\Queue\Interfaces\Job;
use App\Queue\Interfaces\QueueInterface;
use App\Queue\Interfaces\ShouldBeUnique;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;
use UnderflowException;

class Queue implements QueueInterface
{
    public function enqueue(Job $job, ?int $attempts = 0): void
    {
        DB::table(config('queue.jobes.table'))->insert([
            'payload' => (string) json_encode($this->getPayload($job)),
            'created_at' => Carbon::now()->timestamp,
            'attempts' => $attempts,
        ]);
    }

    /**
     * @throws Throwable
     */
    public function dequeue(): DbJob
    {
        throw_if($this->isEmpty(), UnderflowException::class);

        return $this->head();
    }

    /**
     * @throws Throwable
     */
    public function head(): DbJob
    {
        throw_if($this->isEmpty(), UnderflowException::class);

        return $this->getDbJob(
            DB::table(config('queue.jobes.table'))->orderBy('id')->first()
        );
    }

    /**
     * @throws Throwable
     */
    public function tail(): DbJob
    {
        throw_if($this->isEmpty(), UnderflowException::class);

        return $this->getDbJob(
            DB::table(config('queue.jobes.table'))->orderByDesc('id')->first()
        );
    }

    public function isEmpty(): bool
    {
        return $this->size() === 0;
    }

    public function size(): int
    {
        return DB::table(config('queue.jobes.table'))->count();
    }

    public function getDbJob(\stdClass $job): DbJob
    {
        return DbJob::from([
            'job' => unserialize(
                json_decode($job->payload)->data->command
            ),
            'attempts' => $job->attempts,
            'id' => $job->id,
        ]);
    }

    public function deleteJob(DbJob $dbJob): void
    {
        if ($dbJob->job instanceof ShouldBeUnique) {
            Cache::delete(config('queue.jobes.unique-prefix').'-'.get_class($dbJob->job));
        }
        DB::table(config('queue.jobes.table'))->delete($dbJob->id);
    }

    public function failed(Job $job, Throwable $exception): void
    {
        $payload = $this->getPayload($job);

        DB::table(config('queue.jobes.failed_table'))->insert([
            'uuid' => $payload['uuid'],
            'queue' => config('queue.jobes.table'),
            'payload' => json_encode($payload),
            'exception' => $exception->getMessage(),
        ]);
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
