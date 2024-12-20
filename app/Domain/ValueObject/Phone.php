<?php

namespace App\Domain\ValueObject;

use App\Domain\ValueObject\Traits\HasCastable;
use App\Domain\ValueObject\Traits\HasToString;
use Spatie\LaravelData\Casts\Castable;

class Phone implements Castable
{
    use HasCastable, HasToString;

    protected string $phone;

    public function __construct(string $phone)
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        $this->phone = "+$phone";
    }

    public function value(): string
    {
        return $this->phone;
    }
}
