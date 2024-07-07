<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends ApiController
{

    /**
     * Display the details of the resource.
     */
    public function index()
    {
        $user = User::findOrFail($this->getUserId());
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($this->getUserId() !== $user->id) {
            return $this->notAuthorized('Unauthorized to edit this user');
        }

        $user->update($request->mappedUserAttributes());
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($this->getUserId() !== $user->id) {
            return $this->notAuthorized('Unauthorized to delete this user');

        }

        $user->delete();
        return $this->ok("User deleted successfully");
    }
}
