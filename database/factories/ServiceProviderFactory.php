<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Users\Models\ServiceProvider;




class ServiceProviderFactory extends Factory
{
    
    /**
     * Summary of model
     * @var 
     */
    protected  $model = ServiceProvider::class;
    public function definition(): array
    {
        static $userIds = null;

        if ($userIds === null) {
            $userIds = User::pluck('id')->shuffle()->toArray();
        }

        $userId = array_pop($userIds);

        return [
            'user_id' => $userId,
            'phone'   => $this->faker->phoneNumber,
            'address' => $this->faker->address(),
            'gender'  => $this->faker->randomElement(['male', 'female']),
        ];
    }
}
