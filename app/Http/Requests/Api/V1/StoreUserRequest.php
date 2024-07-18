<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isSuperAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^[+]998([0-9][012345789]|[0-9][125679]|7[01234569])[0-9]{7}$/', Rule::unique('users', 'phone')],
            'password' => ['required', 'string', 'min:6', 'max:64', 'regex:/^[a-zA-Z0-9_.#?!@$%^&*-]*$/'],
            'role_id' => ['required', Rule::in([Role::ADMIN->value, Role::SUPER_ADMIN->value])]
        ];
    }

    public function messages(): array
    {
        return [
            'phone.string' => 'Поле телефона должно быть строкой.',
            'phone.regex' => 'Неверный формат поля телефона.',
            'password.string' => 'Поле пароля должно быть строкой.',
            'password.max' => 'Поле пароля не должно превышать 255 символов.',
            'password.min' => 'Поле пароля должно быть не менее 6 символов.',
            'password.regex' => 'Неверный формат поля пароля.',
        ];
    }
}
