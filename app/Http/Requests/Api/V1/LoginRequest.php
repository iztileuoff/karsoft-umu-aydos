<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'phone' => ['required', 'string', 'regex:/^[+]998([0-9][012345789]|[0-9][125679]|7[01234569])[0-9]{7}$/'],
            'password' => ['required', 'string', 'max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'Поле телефона обязательно.',
            'phone.string' => 'Поле телефона должно быть строкой.',
            'phone.regex' => 'Неверный формат поля телефона.',
            'password.required' => 'Поле пароля является обязательным.',
            'password.string' => 'Поле пароля должно быть строкой.',
            'password.max' => 'Поле пароля не должно превышать 255 символов.'
        ];
    }
}
