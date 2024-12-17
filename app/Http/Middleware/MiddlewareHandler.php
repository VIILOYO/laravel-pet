<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Configuration\Middleware;

class MiddlewareHandler
{
    // Тут алиасы, как в ларе до 11
    /** @var string[] */
    protected array $aliases = [];

    public function __invoke(Middleware $middleware): Middleware
    {
        if ($this->aliases) {
            $middleware->alias($this->aliases);
        }

        return $middleware;
    }
}
