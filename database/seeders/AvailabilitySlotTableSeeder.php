<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Users\Models\AvailabilitySlot;

class AvailabilitySlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("availability_slots")->delete();

        AvailabilitySlot::factory(20)->create();
    }
}
