<?php

namespace Modules\Appointments\Http\Requests\Appointments;

use App\Enum\UserRoles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Modules\Appointments\Models\Appointment;

class AppointmentStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'service_id' => 'required|exists:services,id',
            'availability_slot_id' => 'required|exists:availability_slots,id',
   
        ];
    }


    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'service_id.required' => 'The service field is required.',
            'service_id.exists' => 'The selected service does not exist.',

            'availability_slot_id.required' => 'The availability slot field is required.',
            'availability_slot_id.exists' => 'The selected availability slot does not exist.',




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
            'coupon_ids' => 'Coupon'

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Appointment::class);
    }
}
