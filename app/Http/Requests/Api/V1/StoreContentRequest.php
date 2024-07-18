<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreContentRequest extends FormRequest
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
            'body_ltn' => ['required', 'string', 'max:10000'],
            'body_cyr' => ['nullable', 'string', 'max:50000']
        ];
    }
}
