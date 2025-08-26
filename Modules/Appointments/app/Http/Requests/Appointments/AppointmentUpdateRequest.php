<?php

namespace Modules\Appointments\Http\Requests\Appointments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;
use Modules\Appointments\Enum\AppointmentStatus;
use Modules\Appointments\Rules\ChangeAppointment;

class AppointmentUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $appointment = $this->route('appointment');
        return [
            'service_id' => 'sometimes|required|exists:services,id',
            'availability_slot_id' => 'sometimes|required|exists:availability_slots,id',
            'status' => ['sometimes', 'required', new Enum(AppointmentStatus::class), new ChangeAppointment($appointment)],

            'coupon_ids' => ['sometimes', 'array'],
            'coupon_ids.*' => ['integer', 'exists:coupons,id', new ChangeAppointment($appointment)],
        ];
    }


    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'service_id.required' => 'The service field is required when provided.',
            'service_id.exists' => 'The selected service does not exist.',

            'user_id.required' => 'The user field is required when provided.',
            'user_id.exists' => 'The selected user does not exist.',

            'availability_slot_id.required' => 'The availability slot field is required when provided.',
            'availability_slot_id.exists' => 'The selected availability slot does not exist.',

            'status.required' => 'The appointment status is required when provided.',
            'status.in' => 'The status must be either pending, confirmed, or cancelled.',


        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'service_id' => 'service',
            'availability_slot_id' => 'availability slot',
            'status' => 'appointment status',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $appointment = $this->route('appointment');
        return  Gate::allows('update', $appointment);
    }
}
