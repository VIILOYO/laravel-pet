<?php

namespace App\Casts;

use App\Domain\ValueObject\Phone;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PhoneCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): ?Phone
    {
        return $value ? new Phone($value) : null;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        return is_null($value) ? null : $value->value();
    }
}
