<?php

namespace App\Di;

use App\Attributes\Resolve;
use App\Services\User\Abstract\IUserService;
use App\Services\User\UserService;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;

class DependencyContainer
{
    /** @var array|string[] */
    protected array $bindings = [
        IUserService::class => UserService::class,
    ];

    /** @phpstan-ignore-next-line */
    public function bind(string $key, callable|string $resolver): void
    {
        $this->bindings[$key] = is_callable($resolver) ? call_user_func($resolver) : $resolver;
    }

    /**
     * @throws ReflectionException
     */
    public function get(string $key): mixed
    {
        $class = $this->bindings[$key] ?? $key;

        $reflectionClass = new ReflectionClass($class);

        $this->bindFromAttribute($reflectionClass);

        $construct = $reflectionClass->getConstructor();

        $parameters = collect();

        if ($construct !== null && ! empty($construct->getParameters())) {
            foreach ($construct->getParameters() as $parameter) {
                /** @var ReflectionNamedType $type */
                $type = $parameter->getType();
                $parameters->push($this->get($type->getName()));
            }
        }

        return new $class(...$parameters->toArray());
    }

    private function bindFromAttribute(ReflectionClass $reflectionClass): void
    {
        $attributes = $reflectionClass->getAttributes(Resolve::class);

        if (! empty($attributes)) {
            foreach ($attributes as $attribute) {
                $this->bind(...$attribute->getArguments());
            }
        }
    }
}
