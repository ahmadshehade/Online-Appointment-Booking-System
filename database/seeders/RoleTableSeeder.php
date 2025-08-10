<?php

namespace Database\Seeders;

use App\Enum\UserRoles;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        $user=User::create([
            'name'=>'admin',
            'email'=>'admin@admin',
            'password'=>Hash::make('123123123')
        ]);

       foreach(UserRoles::cases() as $roleData){
        Role::firstOrCreate([
            'name'=>$roleData,
            'guard_name'=>'web'
        ]);
       }

        $user->assignRole(UserRoles::SuperAdmin->value);
    }
}
