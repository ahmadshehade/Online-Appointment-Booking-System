<?php

namespace Modules\Appointments\Http\Requests\Appointments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;
use Modules\Appointments\Enum\AppointmentStatus;
use Modules\Appointments\Models\Service;
use Modules\Appointments\Rules\ChangeAppointment;
use Modules\Appointments\Rules\TotalDiscountNotExceedHundred;
use Modules\Users\Models\AvailabilitySlot;

class AppointmentUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $appointment = $this->route('appointment');
        $couponIds = $this->input('coupon_ids', []);
        return [
            'service_id' => 'sometimes|required|exists:services,id',
            'availability_slot_id' => 'sometimes|required|exists:availability_slots,id',
            'status' => ['sometimes', 'required', new Enum(AppointmentStatus::class), new ChangeAppointment($appointment)],

            'coupon_ids' => ['sometimes', 'array', new ChangeAppointment($appointment),new TotalDiscountNotExceedHundred($couponIds)],
            'coupon_ids.*' => ['integer', 'exists:coupons,id'],
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


    /**
     * Summary of messages
     * @return array{availability_slot_id.exists: string, availability_slot_id.required: string, service_id.exists: string, service_id.required: string, status.enum: string, status.required: string}
     */
    public function messages(): array
    {
        return [
            'service_id.required' => 'The service field is required when provided.',
            'service_id.exists' => 'The selected service does not exist.',

            'availability_slot_id.required' => 'The availability slot field is required when provided.',
            'availability_slot_id.exists' => 'The selected availability slot does not exist.',

            'status.required' => 'The appointment status is required when provided.',
            'status.enum' => 'The status must be either pending, confirmed, or cancelled.',
        ];
    }

    /**
     * Summary of withValidator
     * @param mixed $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $serviceId = $this->input('service_id');
            $slotId = $this->input('availability_slot_id');

            if ($serviceId && $slotId) {
                $service = Service::find($serviceId);
                $slot = AvailabilitySlot::find($slotId);

                if ($service && $slot) {
                    if ($slot->service_provider_id !== $service->service_provider_id) {
                        $validator->errors()->add(
                            'availability_slot_id',
                            'The selected availability slot does not belong to the service provider of this service.'
                        );
                    }
                }
            }

          
        });
    }
}
