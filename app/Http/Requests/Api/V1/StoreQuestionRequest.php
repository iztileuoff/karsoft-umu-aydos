<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuestionRequest extends FormRequest
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
            'title_ltn' => ['required', 'string', 'max:100'],
            'title_cyr' => ['nullable', 'string', 'max:500'],
            'question_type_id' => ['required', Rule::exists('question_types', 'id')],
            'answer_explanation_ltn' => ['nullable', 'string', 'max:100'],
            'answer_explanation_cyr' => ['nullable', 'string', 'max:500'],
        ];
    }
}
