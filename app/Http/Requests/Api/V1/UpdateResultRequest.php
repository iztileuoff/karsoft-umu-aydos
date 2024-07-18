<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateResultRequest extends FormRequest
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
            'questions' => ['array'],
            'questions.*.id' => ['required', 'integer'],
            'questions.*.options' => ['array'],
            'questions.*.options.*.id' => ['required', 'integer'],
            'questions.*.options.*.is_selected' => ['boolean'],
            'questions.*.answer_text' => ['string', 'max:255'],
        ];
    }
}
