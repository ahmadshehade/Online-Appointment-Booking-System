<?php

namespace App\Http\Requests\User;

use App\Rules\ChangeActiveRole;
use App\Rules\ChangeStatusRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');

        return [
            "name"     => ['sometimes', 'string', 'max:200', 'min:5'],
            'email'    => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['sometimes', 'confirmed', 'string', 'min:8', "max:16"],
            'active'   => ['sometimes', 'boolean', new ChangeActiveRole()],
        ];
    }

    /**
     * Custom attribute names for clearer validation messages
     */
    public function attributes(): array
    {
        return [
            'name'     => 'user name',
            'email'    => 'email address',
            'password' => 'password',
            'status'   => 'status',
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'name.string'     => 'The :attribute must be a valid string.',
            'name.max'        => 'The :attribute may not be greater than :max characters.',
            'name.min'        => 'The :attribute must be at least :min characters.',

            'email.email'     => 'The :attribute must be a valid email address.',
            'email.unique'    => 'The :attribute has already been taken.',

            'password.confirmed' => 'The :attribute confirmation does not match.',
            'password.min'       => 'The :attribute must be at least :min characters.',
            'password.max'       => 'The :attribute may not be greater than :max characters.',

            'status.boolean'     => 'The :attribute field must be true or false.',
        ];
    }
}
