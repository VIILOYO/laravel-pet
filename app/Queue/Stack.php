<?php

namespace App\Queue;

use App\Queue\Interfaces\StackInterface;
use Throwable;
use UnderflowException;

class Stack implements StackInterface
{
    /**
     * @var mixed[]
     */
    private array $stack = [];

    public function push($item): void
    {
        $this->stack[] = $item;
    }

    /**
     * @throws Throwable
     */
    public function pop(): void
    {
        throw_if($this->isEmpty(), UnderflowException::class);

        array_pop($this->stack);
    }

    /**
     * @throws Throwable
     */
    public function top(): mixed
    {
        throw_if($this->isEmpty(), UnderflowException::class);

        return $this->stack[$this->size() - 1];
    }

    public function isEmpty(): bool
    {
        return empty($this->stack);
    }

    public function size(): int
    {
        return count($this->stack);
    }
}
