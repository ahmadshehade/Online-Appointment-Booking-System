<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $this->call([
            RoleTableSeeder::class,
            ServiceProviderTableSeeder::class,
            AvailabilitySlotTableSeeder::class,
            CategoryTableSeeder::class,
            CouponTableSeeder::class,
            ServiceTableSeeder::class,
            AppointmentTableSeeder::class,
        ]);
    }
}
