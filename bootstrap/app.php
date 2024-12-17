<?php

use App\Console\ScheduleHandler;
use App\Exceptions\ExceptionHandler;
use App\Http\Middleware\MiddlewareHandler;
use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(new MiddlewareHandler())
    ->withExceptions(new ExceptionHandler())
    ->withSchedule(new ScheduleHandler())
    ->withCommands([__DIR__.'/../app/Console/Commands'])
    ->create();
