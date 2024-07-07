<?php

namespace App\Http\Controllers;

use App\Http\Filters\ProjectFilter;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;

class ProjectController extends ApiController
{

    /**
     * Display a listing of the resource.
     */
    public function index(ProjectFilter $filters)
    {
        $projects = Project::query()
            ->where('user_id', $this->getUserId())
            ->filter($filters)
            ->paginate();
        return ProjectResource::collection($projects);
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
        if (!$this->isAble($project)) {
            return $this->notAuthorized('Unauthorized to show this project');
        }

        return new ProjectResource($project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        if (!$this->isAble($project)) {
            return $this->notAuthorized('Unauthorized to edit this project');
        }

        $project->update($request->mappedAttributes());
        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if (!$this->isAble($project)) {
            return $this->notAuthorized('Unauthorized to delete this project');
        }

        $project->delete();

    }
}
