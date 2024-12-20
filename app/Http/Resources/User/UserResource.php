<?php

namespace App\Http\Resources\User;

use App\Helpers\CountryHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * @return array<string, string|int>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email?->value(),
            'phone' => $this->phone->value(),
            'country' => CountryHelper::getCountryByCode($this->country),
        ];
    }
}
