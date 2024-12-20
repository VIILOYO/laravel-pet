<?php

namespace App\Domain\ValueObject\Traits;

trait HasToString
{
    public function __toString(): string
    {
        return (string) $this->value();
    }
}
