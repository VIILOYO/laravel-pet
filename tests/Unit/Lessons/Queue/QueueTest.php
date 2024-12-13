<?php

namespace Lessons\Queue;

use App\Queue\Interfaces\QueueInterface;
use App\Queue\Queue;
use PHPUnit\Framework\TestCase;
use UnderflowException;

class QueueTest extends TestCase
{
    public function test_implementing(): void
    {
        $this->assertInstanceOf(QueueInterface::class, new Queue);
    }

    public function test_queue_enqueue(): void
    {
        $queueItems = ['queue 1', 'queue 2', 'queue 3', 'queue 4'];

        $queue = new Queue;

        $this->assertTrue($queue->isEmpty());

        foreach ($queueItems as $key => $item) {
            $this->assertEquals($key, $queue->size());

            $queue->enqueue($item);
        }

        $this->assertEquals(count($queueItems), $queue->size());

        $this->assertEquals($queueItems[0], $queue->head());
    }

    public function test_queue_dequeue(): void
    {
        $queueItems = ['queue 1', 'queue 2', 'queue 3', 'queue 4'];

        $queue = new Queue;

        $this->assertTrue($queue->isEmpty());

        foreach ($queueItems as $item) {
            $queue->enqueue($item);
        }

        $queue->dequeue();

        $this->assertEquals(count($queueItems) - 1, $queue->size());

        $this->assertEquals($queueItems[1], $queue->head());
    }

    public function test_queue_dequeue_exception(): void
    {
        $this->expectException(UnderflowException::class);

        $queue = new Queue;

        $queue->dequeue();
    }

    public function test_queue_head_exception(): void
    {
        $this->expectException(UnderflowException::class);

        $queue = new Queue;

        $queue->head();
    }

    public function test_queue_tail_exception(): void
    {
        $this->expectException(UnderflowException::class);

        $queue = new Queue;

        $queue->tail();
    }
}
