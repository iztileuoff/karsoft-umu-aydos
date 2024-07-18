<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTariffRequest extends FormRequest
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
            'title_ltn' => ['string', 'max:100'],
            'title_cyr' => ['nullable', 'string', 'max:500'],
            'description_ltn' => ['string', 'max:1000'],
            'description_cyr' => ['nullable', 'string', 'max:5000'],
            'month' => ['integer', 'min:1', 'max:1000'],
            'price' => ['integer', 'min:1', 'max:999999999']
        ];
    }
}
