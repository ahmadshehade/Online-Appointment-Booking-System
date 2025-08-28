<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Appointments\Models\Appointment;
use Modules\Appointments\Models\Service;
use Modules\Users\Models\AvailabilitySlot;

/**
 * Summary of AppointmentFactory
 */
class AppointmentFactory extends Factory
{

    protected $model = Appointment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => Service::inRandomOrder()->value('id'),
            'user_id' => User::inRandomOrder()->value('id'),
            'availability_slot_id' => AvailabilitySlot::inRandomOrder()->value('id'),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
        ];
    }
}
