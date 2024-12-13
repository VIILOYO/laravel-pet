<?php

namespace App\Queue;

use App\Queue\Interfaces\QueueInterface;
use Throwable;
use UnderflowException;

class Queue implements QueueInterface
{
    /**
     * @var mixed[]
     */
    private array $queue = [];

    public function enqueue($item): void
    {
        $this->queue[] = $item;
    }

    /**
     * @throws Throwable
     */
    public function dequeue(): void
    {
        throw_if($this->isEmpty(), UnderflowException::class);

        array_shift($this->queue);
    }

    /**
     * @throws Throwable
     */
    public function head(): mixed
    {
        throw_if($this->isEmpty(), UnderflowException::class);

        return $this->queue[0];
    }

    /**
     * @throws Throwable
     */
    public function tail(): mixed
    {
        throw_if($this->isEmpty(), UnderflowException::class);

        return $this->queue[$this->size() - 1];
    }

    public function isEmpty(): bool
    {
        return empty($this->queue);
    }

    public function size(): int
    {
        return count($this->queue);
    }
}
