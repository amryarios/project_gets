<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'userid' => 'admin',
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'role_id' => Role::where('name', 'Admin')->first()->id
        ]);
    }
}
