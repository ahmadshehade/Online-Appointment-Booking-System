<?php

namespace Modules\Appointments\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Modules\Appointments\Models\Coupon;

class UpdateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $coupon = $this->route('coupon');

        return Gate::allows('update', $coupon);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $coupon = $this->route('coupon');

        return [
            'code' => ['sometimes', 'string', 'max:50', 'unique:coupons,code,' . $coupon->id],
            'discount' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }

    /**
     * Custom attribute names for clearer validation messages.
     */
    public function attributes(): array
    {
        return [
            'code' => 'coupon code',
            'discount' => 'discount percentage',
            'expires_at' => 'expiration date',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'code.unique' => 'The :attribute has already been taken.',
            'discount.numeric' => 'The :attribute must be a number.',
            'discount.min' => 'The :attribute must be at least :min.',
            'discount.max' => 'The :attribute may not be greater than :max.',
            'expires_at.date' => 'The :attribute must be a valid date.',
            'expires_at.after' => 'The :attribute must be a future date.',
        ];
    }
}
