<?php

namespace App\Domain\ValueObject;

use App\Domain\ValueObject\Traits\HasCastable;
use App\Domain\ValueObject\Traits\HasToString;
use InvalidArgumentException;
use Spatie\LaravelData\Casts\Castable;

class Email implements Castable
{
    use HasCastable, HasToString;

    protected string $email;

    public function __construct(string $email)
    {
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Недопустимый email адрес');
        }

        $this->email = $email;
    }

    public function value(): string
    {
        return $this->email;
    }
}
