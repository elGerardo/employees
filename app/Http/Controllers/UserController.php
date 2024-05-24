<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    //
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function store(StoreUserRequest $request)
    {
        return new UserResource(User::create($request->validated()));
    }

    public function show(String $user_id)
    {
        return new UserResource(User::findOrFail($user_id));
    }

    public function update(UpdateUserRequest $request, int $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->update($request->validated());
        $user->save();
        return new UserResource($user);
    }

    public function destroy(String $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();
        return response()->json([], 204);
    }
}
