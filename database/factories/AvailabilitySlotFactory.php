<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Users\Models\AvailabilitySlot;
use Modules\Users\Models\ServiceProvider;

class AvailabilitySlotFactory extends Factory
{

    protected $model = AvailabilitySlot::class;
    public function definition(): array
    {



        $start = $this->faker->time('H:i');
        $end   = date('H:i', strtotime($start . ' +2 hours'));

        return [
            'service_provider_id' => ServiceProvider::inRandomOrder()->value('id'),
            'day_of_week'         => $this->faker->randomElement([
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Sunday'
            ]),
            'start_time'          => $start,
            'end_time'            => $end,
        ];
    }
}
