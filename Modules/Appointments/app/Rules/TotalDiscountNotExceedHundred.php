<?php
namespace Modules\Appointments\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Appointments\Models\Coupon;

class TotalDiscountNotExceedHundred implements Rule
{
    protected array $couponIds;

    public function __construct(array $couponIds)
    {
        $this->couponIds = $couponIds;
    }

    public function passes($attribute, $value): bool
    {
        $couponsPercentage = Coupon::whereIn('id', $this->couponIds)->sum('discount');
        return $couponsPercentage <= 100;
    }

    public function message(): string
    {
        return 'The total discount cannot exceed 100%.';
    }
}
