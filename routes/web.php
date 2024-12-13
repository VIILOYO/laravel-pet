<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('test', function () {
    $stack = new \App\Queue\Stack;

    $stack->push('stack 1');
    $stack->push('stack 2');
    $stack->push('stack 3');
    $stack->push('stack 4');

    $stack->pop();

    $queue = new \App\Queue\Queue;

    $queue->enqueue('queue 1');
    $queue->enqueue('queue 2');
    $queue->enqueue('queue 3');
    $queue->enqueue('queue 4');

    $queue->dequeue();

    dd($stack, $queue);
});
