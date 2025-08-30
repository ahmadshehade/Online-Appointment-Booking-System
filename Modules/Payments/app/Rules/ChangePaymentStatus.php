<?php

namespace Modules\Payments\Rules;

use App\Enum\UserRoles;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;
use Modules\Payments\Models\Payment;

class ChangePaymentStatus implements ValidationRule
{
    protected ?Payment $payment;

    /**
     * Summary of __construct
     * @param int $paymentId
     */
    public function __construct(int $paymentId)
    {
        $this->payment = Payment::with('appointment.service.serviceProvider')->find($paymentId);
    }

    /**
     * Summary of validate
     * @param string $attribute
     * @param mixed $value
     * @param \Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$this->payment) {
            $fail(__('Payment record not found.'));
            return;
        }

        if ($user->hasRole(UserRoles::SuperAdmin)) {
            return;
        }

        if (
            $user->hasRole(UserRoles::Provider) &&
            $this->payment->appointment &&
            $this->payment->appointment->service &&
            $this->payment->appointment->service->serviceProvider &&
            $this->payment->appointment->service->serviceProvider->id === $user->serviceProvider->id
        ) {
            return;
        }

        $fail(__('You cannot update this payment status to paid.'));
    }
}
