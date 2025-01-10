<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FunctionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        require_once __DIR__.'/../Helpers/functions.php';
    }
}
