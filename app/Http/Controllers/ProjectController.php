<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{


    private function getUserId(): int
    {
        return Auth::user()->id;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = Project::query()->where('user_id', $this->getUserId())->get();
        return  ProjectResource::collection($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->mappedAttributes($this->getUserId()));
        return new ProjectResource($project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        if ($this->getUserId() !== $project->user_id) {
            return response()->json([
                'message' => 'Unauthorized to show this project',
            ], 403);
        }

        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        if ($this->getUserId() !== $project->user_id) {
            return response()->json([
                'message' => 'Unauthorized to edit this project',
            ], 403);
        }

        $project->update($request->mappedAttributes());
        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if ($this->getUserId() !== $project->user_id) {
            return response()->json([
                'message' => 'Unauthorized to delete this project',
            ], 403);
        }

        $project->delete();
        return response()->json([
            'message' => "Successfully deleted",
        ], 200);
    }
}
