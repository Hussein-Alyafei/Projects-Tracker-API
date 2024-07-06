<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        //fill primary attributes
        $attributes = [
            'title' => $this->title,
            'status' => $this->status,
            'deadline' => $this->deadline,
        ];

        /**
         * Check if it's the (show, store, or update) method or if the request includes the 'details' parameter
         * to determine whether additional attributes should be shown or not.
         */
        if ($request->routeIs('projects.show', 'projects.store', 'projects.update') || $request->query('include') === 'details') {
            $additionalAttributes = [
                'year' => $this->year,
                'term' => $this->term,
                'gitHub_url' => $this->gitHub_url,
                'documentation' => $this->documentation,
                'description' => $this->description,
            ];

            $attributes = array_merge($attributes, $additionalAttributes);
        }

        return [
            'type' => 'Project',
            'id' => $this->id,
            'attributes' => $attributes,
        ];
    }
}
