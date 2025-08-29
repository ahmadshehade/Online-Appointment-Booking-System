<?php

namespace Modules\Payments\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Modules\Payments\Models\Payment;

class PaymentStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "appointment_id" => ['required', 'integer', 'exists:appointments,id'],
            "amount"         => ['required', 'numeric', 'min:0.01'], 
        ];
    }

    /**
     * Custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'appointment_id.required' => 'The :attribute field is required.',
            'appointment_id.integer'  => 'The :attribute must be a valid number.',
            'appointment_id.exists'   => 'The selected :attribute is invalid.',

            'amount.required' => 'The :attribute field is required.',
            'amount.numeric'  => 'The :attribute must be a valid number.',
            'amount.min'      => 'The :attribute must be greater than 0.',
        ];
    }

    /**
     * Custom attribute names for clearer error messages.
     */
    public function attributes(): array
    {
        return [
            'appointment_id' => 'appointment',
            'amount'         => 'payment amount',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Payment::class);
    }
}
