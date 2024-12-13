<?php

namespace Lessons\Stack;

use App\Queue\Interfaces\StackInterface;
use App\Queue\Stack;
use PHPUnit\Framework\TestCase;
use UnderflowException;

class StackTest extends TestCase
{
    public function test_implementing(): void
    {
        $this->assertInstanceOf(StackInterface::class, new Stack);
    }

    public function test_stack_push(): void
    {
        $stackItems = ['stack 1', 'stack 2', 'stack 3', 'stack 4'];

        $stack = new Stack;

        $this->assertTrue($stack->isEmpty());

        foreach ($stackItems as $key => $item) {
            $this->assertEquals($key, $stack->size());

            $stack->push($item);
        }

        $this->assertEquals(count($stackItems), $stack->size());

        $this->assertEquals($stackItems[count($stackItems) - 1], $stack->top());
    }

    public function test_stack_pop(): void
    {
        $stackItems = ['stack 1', 'stack 2', 'stack 3', 'stack 4'];

        $stack = new Stack;

        $this->assertTrue($stack->isEmpty());

        foreach ($stackItems as $item) {
            $stack->push($item);
        }

        $stack->pop();

        $this->assertEquals($stackItems[count($stackItems) - 2], $stack->top());
    }

    public function test_stack_pop_exception(): void
    {
        $this->expectException(UnderflowException::class);

        $stack = new Stack;

        $stack->pop();
    }

    public function test_stack_top_exception(): void
    {
        $this->expectException(UnderflowException::class);

        $stack = new Stack;

        $stack->top();
    }
}
