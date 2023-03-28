<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Client',
                'email' => 'client@gmail.com',
                'password' => sha1('123456'),
                'type' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => sha1('12345678'),
                'type' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Modarator',
                'email' => 'modarator@gmail.com',
                'password' => sha1('1234567'),
                'type' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
        ]);
    }
}
