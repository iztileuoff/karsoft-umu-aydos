<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLessonRequest extends FormRequest
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
            'module_id' => ['required', Rule::exists('modules', 'id')],
            'lesson_type_id' => ['required', Rule::exists('lesson_types', 'id')],
            'title_ltn' => ['required', 'string', 'max:100'],
            'title_cyr' => ['nullable', 'string', 'max:500'],
            'is_free' => ['required', 'boolean']
        ];
    }
}
