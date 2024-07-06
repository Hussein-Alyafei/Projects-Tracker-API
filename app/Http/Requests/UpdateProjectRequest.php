<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateProjectRequest extends BaseProjectRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'data.attributes.title' => [
                'sometimes',
                'string',
                'min:5',
                'max:100',
                Rule::unique('projects', 'title')->ignore($this->project),
            ],
            'data.attributes.status' => 'sometimes|in:completed,in-progress,stopped,planned,on hold,cancelled',
            'data.attributes.year' =>  'sometimes|in:first,second,third,fourth,fifth,sixth,seventh',
            'data.attributes.term' => 'sometimes|in:first,second',
            'data.attributes.deadline' => 'sometimes|date|after_or_equal:2024-01-01',
            'data.attributes.gitHub_url' => 'nullable|url|max:255',
            'data.attributes.documentation' => 'sometimes|string|max:255',
            'data.attributes.description' => 'sometimes|string',
        ];
    }
}
