<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Appointments\Models\Coupon;
use Modules\Users\Models\ServiceProvider;
use Illuminate\Support\Str;

class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition(): array
    {
        return [
            'service_provider_id' => ServiceProvider::inRandomOrder()->value('id'),
            'code'                => strtoupper(Str::random(8)), 
            'discount'            => $this->faker->randomFloat(2, 5, 50), 
            'expires_at'          => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
        ];
    }
}
