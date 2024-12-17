<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions as BaseExceptions;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use Sentry\Laravel\Integration;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionHandler
{
    public function __invoke(BaseExceptions $exceptions): BaseExceptions
    {
        $this->renderBusiness($exceptions);
        $this->renderUnauthorized($exceptions);
        $this->renderNotFound($exceptions);
        $this->reportSentry($exceptions);

        return $exceptions;
    }

    protected function renderBusiness(BaseExceptions $exceptions): void
    {
        $exceptions->renderable(
            fn (BusinessException $e, ?Request $request = null) => $this->response(
                message: $e->getUserMessage(),
                code: $e->getCode(),
                asJson: $request?->expectsJson() ?? false
            )
        );
    }

    protected function renderUnauthorized(BaseExceptions $exceptions): void
    {
        $exceptions->renderable(
            fn (AuthenticationException $e, ?Request $request = null) => $this->response(
                message: $e->getMessage(),
                code: 401,
                asJson: $request?->expectsJson() ?? false
            )
        );
    }

    protected function renderNotFound(BaseExceptions $exceptions): void
    {
        $exceptions->renderable(
            fn (NotFoundHttpException $e, ?Request $request = null) => $this->response(
                message: $e->getMessage(),
                code: 404,
                asJson: $request?->expectsJson() ?? false
            )
        );
    }

    protected function reportSentry(BaseExceptions $exceptions): void
    {
        $exceptions->reportable(
            fn (Throwable $e) => Integration::captureUnhandledException($e)
        );
    }

    protected function response(string $message, int $code, bool $asJson): Response|JsonResponse
    {
        if ($asJson) {
            return response()->json(compact('message'), $code);
        }

        $this->registerErrorViewPaths();

        return response()->view($this->view($code), status: $code);
    }

    protected function view(int $code): string
    {
        return view()->exists('errors::'.$code) ? 'errors::'.$code : 'errors::400';
    }

    protected function registerErrorViewPaths(): void
    {
        View::replaceNamespace(
            'errors',
            /** @phpstan-ignore-next-line  */
            collect(config('view.paths'))
                ->map(fn (string $path) => "$path/errors")
                ->push($this->vendorViews())
                ->all()
        );
    }

    protected function vendorViews(): string
    {
        return __DIR__.'/../../vendor/laravel/framework/src/Illuminate/Foundation/Exceptions/views';
    }
}
