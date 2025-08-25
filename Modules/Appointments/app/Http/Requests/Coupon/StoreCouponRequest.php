<?php

namespace Modules\Appointments\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Modules\Appointments\Models\Coupon;

class StoreCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        
        return Gate::allows('create', Coupon::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:50', 'unique:coupons,code'],
            'discount' => ['required', 'numeric', 'min:0', 'max:100'],
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
            'code.required' => 'The :attribute is required.',
            'code.unique' => 'The :attribute has already been taken.',
            'discount.required' => 'The :attribute is required.',
            'discount.numeric' => 'The :attribute must be a number.',
            'discount.min' => 'The :attribute must be at least :min.',
            'discount.max' => 'The :attribute may not be greater than :max.',
            'expires_at.date' => 'The :attribute must be a valid date.',
            'expires_at.after_or_equal' => 'The :attribute must be a future date.',
        ];
    }
}
