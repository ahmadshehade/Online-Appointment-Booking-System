<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * For now, everyone is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * These rules validate the data submitted during user registration.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The :attribute field is mandatory.',
            'name.string' => 'The :attribute must be a valid string.',
            'name.max' => 'The :attribute may not be greater than :max characters.',

            'email.required' => 'Please provide your :attribute.',
            'email.email' => 'Please provide a valid :attribute address.',
            'email.unique' => 'The :attribute has already been taken.',

            'password.required' => 'The :attribute is required.',
            'password.min' => 'The :attribute must be at least :min characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }

    /**
     * Custom attributes names for validation errors.
     * This replaces field names with more friendly names in error messages.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'name',
            'email' => 'email address',
            'password' => 'password',
        ];
    }
}
