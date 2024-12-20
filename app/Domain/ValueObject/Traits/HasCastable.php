<?php

namespace App\Domain\ValueObject\Traits;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

trait HasCastable
{
    /**
     * @param  array<mixed>  ...$arguments
     */
    public static function dataCastUsing(...$arguments): Cast
    {
        return new class(self::class) implements Cast
        {
            public function __construct(protected string $valueObject) {}

            /**
             * @param  array<mixed>  $context
             */
            public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): mixed
            {

                return new $this->valueObject($value);
            }
        };
    }
}
