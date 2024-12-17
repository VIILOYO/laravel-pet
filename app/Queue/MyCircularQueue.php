<?php

namespace App\Queue;

class MyCircularQueue
{
    /** @var mixed[] */
    private array $queue = [];

    private int $rear = 0;

    private int $front = 0;

    private int $length;

    public function __construct(int $length)
    {
        $this->length = $length;
    }

    public function enQueue(mixed $value): bool
    {
        if ($this->isFull()) {
            return false;
        }

        $this->queue[$this->rear] = $value;
        $this->rear++;

        return true;
    }

    public function deQueue(): bool
    {
        if ($this->isEmpty()) {
            return false;
        }

        unset($this->queue[$this->front]);
        $this->front++;

        if ($this->isEmpty()) {
            $this->recoverCursors();
        }

        return true;
    }

    public function front(): mixed
    {
        if ($this->isEmpty()) {
            return -1;
        }

        return $this->queue[$this->front];
    }

    public function rear(): mixed
    {
        if ($this->isEmpty()) {
            return -1;
        }

        return $this->queue[$this->rear - 1];
    }

    public function isEmpty(): bool
    {
        return empty($this->queue);
    }

    public function isFull(): bool
    {
        return count($this->queue) === $this->length;
    }

    private function recoverCursors(): void
    {
        $this->front = 0;
        $this->rear = 0;
    }
}
