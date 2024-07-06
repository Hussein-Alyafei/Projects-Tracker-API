<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseProjectRequest extends FormRequest
{
    public function mappedAttributes($user_id = null)
    {

        $attributesToUpdate = [];

        $keysToUpdate = [
            'title',
            'status',
            'year',
            'term',
            'deadline',
            'gitHub_url',
            'documentation',
            'description',
        ];

        foreach ($keysToUpdate as $key) {
            if ($this->has("data.attributes.$key")) {
                $value = $this->input("data.attributes.$key");

                // Map attribute key to value for update
                $attributesToUpdate[$key] = $value;
            }
        }

        // Conditionally set user_id for store operation
        if ($this->routeIs('projects.store')) {
            $attributesToUpdate['user_id'] = $user_id;
        }

        return $attributesToUpdate;
    }


    public function messages()
    {
        return [
            'data.attributes.status.required' => 'The data.attributes.status field is required.',
            'data.attributes.status.in' => 'The data.attributes.status value is invalid. Please enter (completedddd, in-progress, stopped, planned, on hold or cancelled).',

            'data.attributes.year.required' => 'The data.attributes.year field is required.',
            'data.attributes.year.in' => 'The data.attributes.year value is invalid. Please enter (first, second, third, fourth, fifth, sixth or seventh).',

            'data.attributes.term.required' => 'The data.attributes.term field is required.',
            'data.attributes.term.in' => 'The data.attributes.term value is invalid. Please enter (first or second).',
        ];
    }
}
