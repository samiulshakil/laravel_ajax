<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => 1,
            'name' => 'Super Admin',
            'email' => 'admin@mail.com',
            'district_id' => 55,
            'upazila_id' => 499,
            'password' => Hash::make('password'),
            'address' => 'Dhaka, Bangladesh',
            'status' => true,
        ]);
    }
}
