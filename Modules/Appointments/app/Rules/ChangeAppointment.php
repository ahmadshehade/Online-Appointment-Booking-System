<?php

namespace Modules\Appointments\Rules;

use App\Enum\UserRoles;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Modules\Appointments\Models\Appointment;

class ChangeAppointment implements Rule
{
    protected Appointment $appointment;

    /**
     * Summary of __construct
     * @param \Modules\Appointments\Models\Appointment $appointment
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();


        if ($user->hasRole(UserRoles::SuperAdmin->value)) {
            return true;
        }


        if ($user->hasRole(UserRoles::Provider->value) && $user->serviceProvider) {
            return $user->serviceProvider->availabilitySlots()
                ->where('id', $this->appointment->availability_slot_id)
                ->exists();
        }

        return false;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'You are not authorized to change the appointment.';
    }
}
