<?php

namespace App\Services\User;

use App\Domain\Dto\Misc\PaginationData;
use App\Domain\Dto\User\UserData;
use App\Helpers\CountryHelper;
use App\Models\User;
use App\Services\User\Abstract\IUserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class UserService implements IUserService
{
    public function getList(PaginationData $data): LengthAwarePaginator
    {
        return User::query()->paginate($data->per_page);
    }

    public function create(UserData $data): User
    {
        return $this->save(new User, $data);
    }

    public function save(User $user, UserData $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            $data->country = $data->country ?? CountryHelper::getLocaleByPhone($data->phone);
            $user->fill($data->toArray());
            $user->save();

            return $user->refresh();
        });
    }

    public function get(int $user_id): User
    {
        /** @var User */
        return User::query()->findOrFail($user_id);
    }

    public function update(UserData $data, int $user_id): User
    {
        return $this->save(
            $this->get($user_id),
            $data
        );
    }

    public function delete(int $user_id): void
    {
        $this->get($user_id)->delete();
    }
}
