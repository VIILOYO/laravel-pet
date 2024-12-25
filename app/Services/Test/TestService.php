<?php

namespace App\Services\Test;

use App\Attributes\Resolve;
use App\Domain\Dto\Misc\PaginationData;
use App\Services\Test\Abstract\ITestResolveAttribute;
use App\Services\Test\Abstract\ITestService;
use App\Services\User\Abstract\IUserService;

#[Resolve(ITestResolveAttribute::class, TestResolveAttribute::class)]
class TestService implements ITestService
{
    public function __construct(
        protected ITestResolveAttribute $testResolveAttribute,
        protected IUserService $userService,
    ) {}

    public function test(): int
    {
        $users = $this->userService->getList(PaginationData::from());
        $testResolveUsers = $this->testResolveAttribute->test();

        return $users->count() + $testResolveUsers;
    }
}
