<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateServiceProviderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
             "phone" => ['sometimes', 'string', 'min:5', 'max:10'],
            "address" => ['sometimes', 'string', 'min:3', 'max:255'],
            "gender" => ['sometimes', 'in:male,female'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $provider=$this->route('service_provider');
        return Gate::allows('update',$provider);
    }


       public function messages(): array
    {
        return [



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
