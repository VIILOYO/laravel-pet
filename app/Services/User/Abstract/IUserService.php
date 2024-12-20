<?php

namespace App\Services\User\Abstract;

use App\Domain\Dto\Misc\PaginationData;
use App\Domain\Dto\User\UserData;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface IUserService
{
    public function create(UserData $data): User;

    public function save(User $user, UserData $data): User;

    public function getList(PaginationData $data): LengthAwarePaginator;

    public function get(int $user_id): User;

    public function update(UserData $data, int $user_id): User;

    public function delete(int $user_id): void;
}
