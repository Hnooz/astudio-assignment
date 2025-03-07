<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = User::latest()->paginate(parent::ELEMENTS_PER_PAGE)->withQueryString();

        return UserResource::collection($user)->additional(['meta' => [
            'success' => true,
            'code' => 200,
            'message' => ResponseEnum::SUCCESS_RESPONSE->name,
            'direct' => null,
        ]]);
    }

    public function show(User $user)
    {
        return $this->sendSuccessResponse(new UserResource($user));
    }

    public function update(StoreUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return $this->sendSuccessResponse(data: new UserResource($user), message: 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return $this->sendSuccessResponse(message: 'User deleted successfully');
    }
}
