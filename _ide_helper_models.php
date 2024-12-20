<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property \App\Domain\ValueObject\Email|null $email
 * @property \App\Domain\ValueObject\Phone $phone
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \App\Builders\UserBuilder<static>|User newModelQuery()
 * @method static \App\Builders\UserBuilder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \App\Builders\UserBuilder<static>|User query()
 * @method static \App\Builders\UserBuilder<static>|User whereCountry($value)
 * @method static \App\Builders\UserBuilder<static>|User whereCreatedAt($value)
 * @method static \App\Builders\UserBuilder<static>|User whereDeletedAt($value)
 * @method static \App\Builders\UserBuilder<static>|User whereEmail($value)
 * @method static \App\Builders\UserBuilder<static>|User whereEmailVerifiedAt($value)
 * @method static \App\Builders\UserBuilder<static>|User whereId($value)
 * @method static \App\Builders\UserBuilder<static>|User whereName($value)
 * @method static \App\Builders\UserBuilder<static>|User wherePassword($value)
 * @method static \App\Builders\UserBuilder<static>|User wherePhone($value)
 * @method static \App\Builders\UserBuilder<static>|User whereRememberToken($value)
 * @method static \App\Builders\UserBuilder<static>|User whereSurname($value)
 * @method static \App\Builders\UserBuilder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

