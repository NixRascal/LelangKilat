<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\UserStoreRequest;
use App\Http\Requests\Api\V1\User\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Support\ApiResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(private readonly UserService $users)
    {
    }

    public function index()
    {
        return ApiResponse::success(
            UserResource::collection($this->users->paginate(request()->all()))
        );
    }

    public function store(UserStoreRequest $request)
    {
        $user = $this->users->create($request->validated());

        return ApiResponse::success(new UserResource($user), 'Pengguna dibuat', Response::HTTP_CREATED);
    }

    public function show(User $user)
    {
        return ApiResponse::success(new UserResource($user));
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $updated = $this->users->update($user, $request->validated());

        return ApiResponse::success(new UserResource($updated), 'Pengguna diperbarui');
    }

    public function destroy(User $user)
    {
        $this->users->destroy($user);

        return ApiResponse::success(null, 'Pengguna dihapus', Response::HTTP_NO_CONTENT);
    }
}
