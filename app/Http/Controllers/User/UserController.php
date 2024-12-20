<?php

namespace App\Http\Controllers\User;

use App\Domain\Dto\Misc\PaginationData;
use App\Domain\Dto\User\UserData;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Services\User\Abstract\IUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        protected IUserService $userService,
    ) {}

    public function list(Request $request): AnonymousResourceCollection
    {
        return UserResource::collection(
            $this->userService->getList(
                PaginationData::validateAndCreate($request)
            )
        );
    }

    public function create(Request $request): UserResource
    {
        return UserResource::make(
            $this->userService->create(
                UserData::validateAndCreate($request)
            )
        );
    }

    public function show(int $user_id): UserResource
    {
        return UserResource::make(
            $this->userService->get($user_id)
        );
    }

    public function update(Request $request, int $user_id): UserResource
    {
        return UserResource::make(
            $this->userService->update(
                UserData::validateAndCreate($request),
                $user_id
            )
        );
    }

    public function delete(int $user_id): Response
    {
        $this->userService->delete($user_id);

        return response(status: 204);
    }
}
