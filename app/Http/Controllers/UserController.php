<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        return UserResource::collection(User::select('*')->filter($request->query())->get());
    }

    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('pictures', 'public');
            $validatedData['picture_url'] = $path;
        }

        $validatedData['status'] = 'Active';
        $user = new User($validatedData);
        $user->save();

        if($user->picture_url != null){
            $path = storage_path('app/public/' . $user->picture_url);
            $type = File::mimeType($path);
            $data = File::get($path);
            $imageBase64 = 'data:' . $type . ';base64,' . base64_encode($data);
            $user->picture_url = $imageBase64;
        }
        return new UserResource($user);
    }

    public function show(String $user_id)
    {
        $user = User::findOrFail($user_id);
        
        $path = storage_path('app/public/' . $user->picture_url);

        if (File::exists($path)) {
            $type = File::mimeType($path);
            $data = File::get($path);
            $base64 = 'data:' . $type . ';base64,' . base64_encode($data);
            $user->picture_url = $base64;
        }
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, int $user_id)
    {
        $user = User::findOrFail($user_id);
        $validatedData = $request->validated();
        $imageBase64 = null;
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('pictures', 'public');
            $validatedData['picture_url'] = $path;
        }

        $user->update($validatedData);
        $user->save();

        if($user->picture_url != null){
            $path = storage_path('app/public/' . $user->picture_url);
            $type = File::mimeType($path);
            $data = File::get($path);
            $imageBase64 = 'data:' . $type . ';base64,' . base64_encode($data);
            $user->picture_url = $imageBase64;
        }
        return new UserResource($user);
    }

    public function destroy(String $user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();
        return response()->json([], 204);
    }
}
