<?php

namespace App\Services\Test;

use App\Domain\Dto\Misc\PaginationData;
use App\Services\Test\Abstract\ITestResolveAttribute;
use App\Services\User\UserService;

class TestResolveAttribute implements ITestResolveAttribute
{
    public function __construct(
        protected UserService $userService,
    ) {}

    public function test(): int
    {
        $users = $this->userService->getList(PaginationData::from());

        return $users->count();
    }
}
