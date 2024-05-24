<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\JsonValidationException;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'name' => 'string',
            'last_name' => 'string',
            'company' => 'string',
            'area' => 'string',
            'department' => 'string',
            'job_title' => 'string',
            'picture' => 'file|image:jpeg,png,jpg',
            'status' => 'string|in:active,inactive',
        ];
    }

    public function failedValidation(Validator $validator): JsonValidationException
    {
        throw new JsonValidationException($validator);
    }
}
