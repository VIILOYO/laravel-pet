<?php

namespace App\Providers;

use App\Services\User\Abstract\IUserService;
use App\Services\User\UserService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** @var array|string[] */
    public array $bindings = [
        IUserService::class => UserService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production' || config('app.force_https') === true) {
            $this->app['request']->server->set('HTTPS', 'on');
            URL::forceScheme('https');
        }

        JsonResource::withoutWrapping();

        Model::preventLazyLoading(! app()->isProduction());

    }
}
