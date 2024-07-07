<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;

abstract class ApiController
{
    use ApiResponses;

    /**
     * Get the currently authenticated user's ID.
     *
     * @return int The ID of the authenticated user.
     */
    protected function getUserId(): int
    {
        return Auth::user()->id;
    }

    /**
     * Check if the authenticated user is authorized to access the given project.
     *
     * @param Project $project The project to check access for.
     * @return bool True if the user is authorized, false otherwise.
     */
    protected function isAble(Project $project)
    {
        $user_id = $this->getUserId();
        return $user_id === $project->user_id;
    }
}
