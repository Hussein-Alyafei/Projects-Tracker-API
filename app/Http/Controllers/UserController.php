<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Echo_;

class UserController extends Controller
{

    private function getUserId(): int
    {
        return Auth::user()->id;
    }

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
            return response()->json([
                'message' => 'Unauthorized to edit this user',
            ], 403);
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
            return response()->json([
                'message' => 'Unauthorized to delte this user',
            ], 403);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
