<?php


namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Modules\Users\Models\AvailabilitySlot;
use Modules\Users\Models\ServiceProvider;

class StoreServiceProviderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create',ServiceProvider::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [

            "phone" => ['required', 'string', 'min:5', 'max:10'],
            "address" => ['sometimes', 'string', 'min:3', 'max:255'],
            "gender" => ['sometimes', 'in:male,female'],
        ];
    }

    /**
     * Get the custom messages for validator errors.
     */
    public function messages(): array
    {
        return [


            'phone.required' => 'The phone number is required.',
            'phone.string' => 'The phone number must be a string.',
            'phone.min' => 'The phone number must be at least :min characters.',
            'phone.max' => 'The phone number must not exceed :max characters.',

            'address.string' => 'The address must be a string.',
            'address.min' => 'The address must be at least :min characters.',
            'address.max' => 'The address must not exceed :max characters.',

            'gender.in' => 'The gender must be either male or female.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'user_id' => 'User ID',
            'phone' => 'Phone Number',
            'address' => 'Address',
            'gender' => 'Gender',
        ];
    }
}

