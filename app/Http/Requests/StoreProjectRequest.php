<?php

namespace App\Http\Requests;


class StoreProjectRequest extends BaseProjectRequest
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
            'data.attributes.title' => 'required|string|min:5|max:100|unique:projects,title',
            'data.attributes.status' => 'required|in:completed,in-progress,stopped,planned,on hold,cancelled',
            'data.attributes.year' =>  'required|in:first,second,third,fourth,fifth,sixth,seventh',
            'data.attributes.term' => 'required|in:first,second',
            'data.attributes.deadline' => 'required|date|after_or_equal:2024-01-01',
            'data.attributes.gitHub_url' => 'nullable|url|max:255',
            'data.attributes.documentation' => 'required|string|max:255',
            'data.attributes.description' => 'required|string',
        ];
    }
}
