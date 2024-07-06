<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'data.email' => 'sometimes', 'email', Rule::unique('users', 'email')->ignore($this->user),
            'data.name' => 'sometimes|string|min:4|max:30',
            'data.password' => 'sometimes|string|min:8|confirmed',
            'data.id' => 'prohibited'
        ];
    }


    public function mappedUserAttributes()
    {
        $attributesToUpdate = [];
        $keysToUpdate = [
            'email',
            'name',
            'password',
        ];

        foreach ($keysToUpdate as $key) {
            if ($this->has("data.$key")) {
                if ($key === 'password') {
                    $attributesToUpdate[$key] = bcrypt($this->input("data.$key"));
                } else {
                    $attributesToUpdate[$key] = $this->input("data.$key");
                }
            }
        }

        return $attributesToUpdate;
    }
}
