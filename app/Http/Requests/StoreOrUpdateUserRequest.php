<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\JsonValidationException;

class StoreOrUpdateUserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            //
            'name' => 'required|string',
            'last_name' => 'required|string',
            'company' => 'required|string',
            'area' => 'required|string',
            'department' => 'required|string',
            'job_title' => 'required|string',
            'picture' => 'file|image:jpeg,png,jpg',
            'status' => 'string|in:Active,Inactive',
        ];
    }

    public function failedValidation(Validator $validator): JsonValidationException
    {
        throw new JsonValidationException($validator);
    }
}
