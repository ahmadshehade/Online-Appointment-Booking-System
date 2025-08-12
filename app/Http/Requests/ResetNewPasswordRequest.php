<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetNewPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules for the request.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'token' => ['required', 'string'],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:32',
                'regex:/^(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*\d).+$/',
                'confirmed'
            ],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'The email format is invalid.',
            'email.exists' => 'This email address is not registered.',

            'token.required' => 'The reset token is required.',
            'token.string' => 'The reset token must be a valid string.',

            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a valid string.',
            'password.min' => 'The password must be at least :min characters.',
            'password.max' => 'The password may not be greater than :max characters.',
            'password.regex' => 'The password must contain at least one uppercase letter and one number.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }

    /**
     * Friendly field names for error messages.
     */
    public function attributes(): array
    {
        return [
            'email' => 'email address',
            'token' => 'reset token',
            'password' => 'new password',
        ];
    }
}
