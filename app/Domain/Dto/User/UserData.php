<?php

namespace App\Domain\Dto\User;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Phone;
use Spatie\LaravelData\Attributes\Validation\Email as EmailValidation;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\WithCastable;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class UserData extends Data
{
    public function __construct(
        #[Max(255)]
        public string $name,
        #[Max(255)]
        public string $surname,
        #[
            Max(255),
            Unique('users', 'phone', ignore: new RouteParameterReference('user_id', nullable: true)),
            WithCastable(Phone::class)
        ]
        public Phone $phone,
        #[
            Max(255),
            EmailValidation,
            Unique('users', 'email', ignore: new RouteParameterReference('user_id', nullable: true)),
            WithCastable(Email::class)
        ]
        public ?Email $email,
        #[Max(255)]
        public ?string $country,
    ) {}
}
